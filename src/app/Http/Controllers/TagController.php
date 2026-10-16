<?php

namespace App\Http\Controllers;

use App\Application\Tag\CreateTag\CreateTagUseCase;
use App\Application\Tag\DeleteTag\DeleteTagUseCase;
use App\Application\Tag\GetTags\GetTagsUseCase;
use App\Application\Tag\UpdateTag\UpdateTagUseCase;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class TagController extends Controller
{
    public function __construct(
        private readonly GetTagsUseCase $getTagsUseCase,
        private readonly CreateTagUseCase $createTagUseCase,
        private readonly UpdateTagUseCase $updateTagUseCase,
        private readonly DeleteTagUseCase $deleteTagUseCase
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->getTagsUseCase->execute();
        return Inertia::render('admin/Tags', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
