<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {

        return view('dashboard.employees.index');
    }

    public function getEmployee()
    {
        $data = Employee::get();
        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('employees.edit', $row->id);
                $deleteUrl = route('employees.destroy', $row->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
                $btn = "<a href='$editUrl' class='edit btn btn-primary btn-sm'>Edit</a>
                                <form action='$deleteUrl' method='POST' style='display:inline'>
                                    $csrf
                                    $method
                                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>";
                return $btn;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="id[]" value="{{$id}}" class="checkbox" />')
            ->rawColumns(['action', 'checkbox'])
            ->addIndexColumn()

            ->make(true);
    }
    public function create()
    {
        return view('dashboard.employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'salary' => 'required|numeric',
        ]);

        $employee = Employee::create($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('dashboard.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'salary' => 'required|numeric',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
