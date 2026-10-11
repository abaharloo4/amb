<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Crud\ResourceManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrudController extends Controller
{
    public function __construct(
        protected ResourceManager $resourceManager
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $resource)
    {
        $config = $this->resourceManager->get($resource);
        $modelClass = $config->model();

        $query = $modelClass::query();

        // Eager load translations if exists on model
        if (method_exists(new $modelClass, 'translations')) {
            $query->with('translations');
        }

        // Search
        if ($search = $request->query('q')) {
            $searchables = $config->searchableColumns();
            $query->where(function ($q) use ($searchables, $search) {
                foreach ($searchables as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        // Ordering
        $defaultOrder = $config->defaultOrder();
        $orderColumn = $request->query('order_by', $defaultOrder['column']);
        $orderDirection = strtolower((string) $request->query('order_dir', $defaultOrder['direction']));

        if (!in_array($orderDirection, ['asc', 'desc'], true)) {
            $orderDirection = 'asc';
        }

        // Whitelist allowed sort columns from index columns and common columns
        $allowedColumns = array_keys($config->columns());
        $allowedColumns = array_merge($allowedColumns, ['id', 'created_at', 'updated_at', 'order']);
        if (!in_array($orderColumn, $allowedColumns, true)) {
            $orderColumn = $defaultOrder['column'] ?? 'id';
        }

        $query->orderBy($orderColumn, $orderDirection);

        $items = $query->paginate($config->perPage())->withQueryString();

        return view('admin.crud.index', [
            'config' => $config,
            'items' => $items,
            'search' => $search,
            'orderColumn' => $orderColumn,
            'orderDirection' => $orderDirection,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $resource)
    {
        $config = $this->resourceManager->get($resource);
        $item = new ($config->model());

        return view('admin.crud.form', [
            'config' => $config,
            'item' => $item,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $resource)
    {
        $config = $this->resourceManager->get($resource);
        $modelClass = $config->model();

        // Extract validation rules
        $rules = [];
        foreach ($config->fields() as $fieldName => $fieldDef) {
            if (isset($fieldDef['rules'])) {
                $rules[$fieldName] = $fieldDef['rules'];
            }
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($config, $modelClass, $validated, $request) {
            $modelData = [];
            $translations = [];

            foreach ($config->fields() as $fieldName => $fieldDef) {
                if (! empty($fieldDef['is_translation'])) {
                    $locale = $fieldDef['locale'] ?? 'fa';
                    $col = $fieldDef['field'];
                    $translations[$locale][$col] = $validated[$fieldName] ?? null;
                } else {
                    $modelData[$fieldName] = $validated[$fieldName] ?? ($fieldDef['default'] ?? null);
                }
            }

            $item = $modelClass::create($modelData);

            if (! empty($translations) && method_exists($item, 'translations')) {
                foreach ($translations as $locale => $fields) {
                    $item->translations()->create(array_merge($fields, ['locale' => $locale]));
                }
            }
        });

        return redirect()->route('admin.crud.index', $resource)->with('success', 'آیتم جدید با موفقیت ثبت شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $resource, int|string $id)
    {
        $config = $this->resourceManager->get($resource);
        $modelClass = $config->model();

        $query = $modelClass::query();
        if (method_exists(new $modelClass, 'translations')) {
            $query->with('translations');
        }

        $item = $query->findOrFail($id);

        return view('admin.crud.form', [
            'config' => $config,
            'item' => $item,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $resource, int|string $id)
    {
        $config = $this->resourceManager->get($resource);
        $modelClass = $config->model();

        $query = $modelClass::query();
        if (method_exists(new $modelClass, 'translations')) {
            $query->with('translations');
        }

        $item = $query->findOrFail($id);

        $rules = [];
        foreach ($config->fields() as $fieldName => $fieldDef) {
            if (isset($fieldDef['rules'])) {
                $rules[$fieldName] = $fieldDef['rules'];
            }
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($config, $item, $validated) {
            $modelData = [];
            $translations = [];

            foreach ($config->fields() as $fieldName => $fieldDef) {
                if (! empty($fieldDef['is_translation'])) {
                    $locale = $fieldDef['locale'] ?? 'fa';
                    $col = $fieldDef['field'];
                    $translations[$locale][$col] = $validated[$fieldName] ?? null;
                } else {
                    $modelData[$fieldName] = $validated[$fieldName] ?? null;
                }
            }

            $item->update($modelData);

            if (! empty($translations) && method_exists($item, 'translations')) {
                foreach ($translations as $locale => $fields) {
                    $item->translations()->updateOrCreate(
                        ['locale' => $locale],
                        $fields
                    );
                }
            }
        });

        return redirect()->route('admin.crud.index', $resource)->with('success', 'تغییرات با موفقیت ذخیره گردید.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $resource, int|string $id)
    {
        $config = $this->resourceManager->get($resource);
        $modelClass = $config->model();

        $item = $modelClass::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.crud.index', $resource)->with('success', 'رکورد مورد نظر با موفقیت حذف شد.');
    }
}
