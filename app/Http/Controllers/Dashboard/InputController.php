<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\InputGroup;
use App\Models\InputField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InputController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $groups = InputGroup::with('fields')->latest()->paginate(10);
        return view('dashboard.inputs.index', compact('groups'));
    }

    public function storeGroup(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        InputGroup::create($data);
        return back()->with('success', 'Grup input berhasil dibuat!');
    }

    public function editGroup(InputGroup $group)
    {
        $group->load('fields');
        return view('dashboard.inputs.edit', compact('group'));
    }

    public function updateGroup(Request $request, InputGroup $group)
    {
        $data    = $request->validate(['name' => 'required|string|max:255']);
        $oldName = $group->name;
        $group->update($data);

        $this->logActivity('UPDATE_INPUT_GROUP', "Mengubah nama template input dari '{$oldName}' menjadi '{$group->name}'");
        return back()->with('success', 'Nama template berhasil diperbarui!');
    }

    public function destroyGroup(InputGroup $group)
    {
        $group->delete();
        return back()->with('success', 'Grup input berhasil dihapus!');
    }

    public function storeField(Request $request, InputGroup $group)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:255',
            'type'       => 'required|in:text,number,tel',
            'placeholder'=> 'nullable|string|max:255',
            'max_length' => 'nullable|integer|min:1',
        ]);

        $data['name'] = Str::slug($data['label'], '_');
        $group->fields()->create($data);

        $this->logActivity('CREATE_INPUT_FIELD', "Menambahkan field '{$data['label']}' ke template '{$group->name}'");
        return back()->with('success', 'Field berhasil ditambahkan!');
    }

    public function updateField(Request $request, InputField $field)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:255',
            'type'       => 'required|in:text,number,tel',
            'placeholder'=> 'nullable|string|max:255',
            'max_length' => 'nullable|integer|min:1',
        ]);

        $oldLabel = $field->label;
        $field->update($data);

        $this->logActivity('UPDATE_INPUT_FIELD', "Mengubah label field dari '{$oldLabel}' menjadi '{$field->label}'");
        return back()->with('success', 'Field berhasil diperbarui!');
    }

    public function destroyField(InputField $field)
    {
        $label     = $field->label;
        $groupName = $field->group->name ?? 'Unknown';
        $field->delete();

        $this->logActivity('DELETE_INPUT_FIELD', "Menghapus field '{$label}' dari template '{$groupName}'");
        return back()->with('success', 'Field berhasil dihapus!');
    }
}
