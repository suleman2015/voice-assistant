<?php

namespace Modules\UrlRedirector\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\UrlRedirector\Models\UrlRedirector;
use Modules\UrlRedirector\Http\Requests\UrlRedirectorRequest;

class UrlRedirectorController extends Controller
{
    public function index()
    {
        $urlRedirects = UrlRedirector::latest()->paginate(10);
        return view('urlredirector::index', compact('urlRedirects'));
    }

    public function create()
    {
        return view('urlredirector::create');
    }

    public function store(UrlRedirectorRequest $request)
    {
        UrlRedirector::create($request->validated());

        return redirect()->route('urlredirector.index')->with('success', 'Redirect created.');
    }

    public function edit(UrlRedirector $urlredirector)
    {
        return view('urlredirector::edit', compact('urlredirector'));
    }


    public function update(UrlRedirectorRequest $request, UrlRedirector $urlredirector)
    {
        $urlredirector->update($request->validated());

        return redirect()->route('urlredirector.index')->with('success', 'Redirect updated.');
    }


    public function destroy(UrlRedirector $urlRedirect)
    {
        $urlRedirect->delete();

        return redirect()->route('urlredirector.index')->with('success', 'Redirect deleted.');
    }
}
