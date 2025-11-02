<?php

namespace App\Livewire\Currencies;

use App\Models\Currency as CurrencyModel;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Currencies extends Component
{
    use WithPagination;
    public $id;

    public function add()
    {
        $this->dispatch(
            'init',
            id: null,
            heading: __('Add Currency'),
            subheading: __('Create a new currency for your financial records.')
        );
    }

    public function edit(int $id)
    {
        $this->dispatch(
            'init',
            id: $id,
            heading: __('Edit Currency'),
            subheading: __('Edit the data for the selected currency.')
        );
    }

    public function confirm(int $id)
    {
        $this->id = $id;
        Flux::modal('confirm')->show();
    }

    public function delete()
    {
        CurrencyModel::findOrFail($this->id)->delete();

        $this->reset();
        Flux::modal('confirm')->close();
        session()->flash('success', __('Currency successfully deleted.'));
        $this->redirectRoute('currencies', navigate: true);
    }

    public function render()
    {
        $rows = CurrencyModel::query()->orderBy('code')->paginate(10);
        return view('livewire.currencies.currencies', [
            'rows' => $rows,
        ]);
    }
}
