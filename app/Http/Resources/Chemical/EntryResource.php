<?php

namespace ChemLab\Http\Resources\Chemical;

use ChemLab\Http\Resources\BaseEntryResource;
use ChemLab\Http\Resources\Brand\EntryResource as BrandResource;
use ChemLab\Http\Resources\ChemicalItem\EntryResource as ChemicalItemResource;
use ChemLab\Http\Resources\ChemicalStructure\EntryResource as ChemicalStructureResource;
use ChemLab\Models\Brand;
use ChemLab\Models\Category;
use ChemLab\Models\User;
use Illuminate\Http\Request;


class EntryResource extends BaseEntryResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'iupac' => $this->iupac,
            'brand_id' => $this->brand_id,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->pluck('id');
            }),
            'catalog_id' => $this->catalog_id,
            'cas' => $this->cas,
            'chemspider' => $this->chemspider,
            'pubchem' => $this->pubchem,
            'mw' => $this->mw,
            'formula' => $this->formula,
            'synonym' => $this->synonym,
            'description' => $this->description,
            'structure' => new ChemicalStructureResource($this->whenLoaded('structure')),
            'items' => ChemicalItemResource::collection($this->whenLoaded('items')),
            'symbol' => $this->symbol,
            'signal_word' => $this->signal_word,
            'h' => $this->h,
            'p' => $this->p,
            'r' => $this->r,
            's' => $this->s
        ], parent::toArray($request));
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        $user = auth()->user();
        return [
            'refs' => [
                'stores' => $user->getManageableStores('chemicals-edit'),
                'brands' => Brand::select('id', 'name', 'parse_callback')
                    ->orderBy('name')
                    ->get()
                    ->prepend(['id' => null, 'parse_callback' => null, 'name' => __('common.not.selected')]),
                'categories' => Category::select('id', 'name')->orderBy('name')->get(),
                'users' => User::select('id', 'name')->orderBy('name')->get()->prepend(['id' => null, 'name' => __('common.not.selected')])
            ]
        ];
    }
}
