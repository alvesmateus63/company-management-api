<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            $department = Department::create($validatedData);
        
            $department->save();

            return response()->json("Successfully registered department", 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }

    }

    public function show(string $id)
    {
        $department = Department::find($id);

        return response()->json($department);
    }

    public function update(Request $request, string $id)
    {
        try {
            $department = Department::find($id);

            if (!$department) {
                return response()->json(['message' => 'Departamento não encontrado'], 404);
            }
        
            if ($request->filled('name')) {
                $department->name = $request->name;
            }
        
            if ($request->filled('description')) {
                $department->description = $request->description;
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }

        $department->save();

        return response()->json("Department Updated Successfully", 201);
    }

    public function destroy(string $id)
    {
        try {
            $department = Department::find($id);
            
            $department->delete();

            return response()->json("Department Delete Successfully", 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
    }
}
