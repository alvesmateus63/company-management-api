<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PositionController extends Controller
{

    public function index()
    {
        $positions = Position::all();
        return response()->json($positions);
    }

    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
    
            $position = Position::create($validatedData);
        
            $position->save();

            return response()->json("Successfully registered position", 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
    }

    public function show(string $id)
    {
        $position = Position::find($id);

        return response()->json($position);
    }

    public function update(Request $request, string $id)
    {
        try {
            $postition = Position::find($id);

            if (!$postition) {
                return response()->json(['message' => 'Departamento não encontrado'], 404);
            }
        
            if ($request->filled('name')) {
                $postition->name = $request->name;
            }
        
            if ($request->filled('description')) {
                $postition->description = $request->description;
            }

            $postition->save();

            return response()->json("Position Updated Successfully", 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $position = Position::find($id);
            
            $position->delete();

            return response()->json("Position Delete Successfully", 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
    }
}
