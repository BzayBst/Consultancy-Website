<?php

namespace App\Repositories;

use App\Models\CoreValue;
use App\Models\CoreValuesSection;
use App\Repositories\Contracts\CoreValuesRepositoryInterface;
use Illuminate\Support\Collection;

class CoreValuesRepository implements CoreValuesRepositoryInterface
{
    public function getSection(): ?CoreValuesSection
    {
        return CoreValuesSection::first();
    }

    public function saveSection(array $data): CoreValuesSection
    {
        $section = CoreValuesSection::firstOrNew(['id' => 1]);
        $section->fill($data)->save();

        return $section->fresh();
    }

    public function getValues(): Collection
    {
        return CoreValue::ordered()->get();
    }

    public function findValue(int $id): CoreValue
    {
        return CoreValue::findOrFail($id);
    }

    public function createValue(array $data): CoreValue
    {
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (CoreValue::max('sort_order') ?? 0) + 1;
        }

        return CoreValue::create($data);
    }

    public function updateValue(int $id, array $data): CoreValue
    {
        $v = $this->findValue($id);
        $v->update($data);

        return $v->fresh();
    }

    public function deleteValue(int $id): void
    {
        $this->findValue($id)->delete();
    }

    public function reorderValues(array $orderedIds): void
    {
        foreach ($orderedIds as $sort => $id) {
            CoreValue::where('id', $id)->update(['sort_order' => $sort + 1]);
        }
    }

    public function toggleValue(int $id): bool
    {
        $v = $this->findValue($id);
        $new = ! $v->is_active;
        $v->update(['is_active' => $new]);

        return $new;
    }
}
    