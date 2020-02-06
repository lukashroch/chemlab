<?php

namespace ChemLab\Jobs;

use ChemLab\Models\Store;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStoreTreeName extends Job
{
    use InteractsWithQueue, SerializesModels;

    protected $store;

    /**
     * Create a new job instance.
     *
     * @param Store $store
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stores = Store::whereIn('id', $this->store->getChildrenIdList())->get();
        foreach ($stores as $store) {
            $treeName = $store->name;
            $parentStore = $store->parent;
            while ($parentStore) {
                if ($parentStore->abbr_name)
                    $treeName = $parentStore->abbr_name . ' ' . $treeName;
                else if (str_word_count($parentStore->name) > 1)
                    $treeName = preg_replace('~\b(\w)|.~', '$1', $parentStore->name) . ' ' . $treeName;
                else
                    $treeName = $parentStore->name . ' ' . $treeName;

                $parentStore = $parentStore->parent;
            }
            $store->tree_name = $treeName;
            $store->save();
        }
    }
}
