<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Component;
use App\Http\Requests\Component\Store;

class ComponentController extends Controller
{
    /**
     * Returns main page for viewing components.
     */
    public function index() {
        $data = [
            'components' => Component::all()
        ];

        return view('components')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Component\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        return DB::transaction(function () use ($request) {
            $component = Component::create($request->all());

            return response()->json([
                'session' => 'Component Created.',
                'component' => $component
            ]);
        });

    }

    /**
     * Update a resource in storage.
     *
     * @param  App\Http\Requests\Component\Store $request
     * @param App\Component $component
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, Component $component)
    {
        return DB::transaction(function () use ($request, $component) {
            $component->fill($request->all());
            $component->save();

            return response()->json([
                'session' => 'Component Updated.',
                'component' => $component
            ]);
        });

    }

    /**
     * Remove a resource in storage.
     *
     * @param App\Component $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        return DB::transaction(function () use ($component) {
            $component->delete();

            return response()->json([
                'session' => 'Component Deleted.'
            ]);
        });

    }
}
