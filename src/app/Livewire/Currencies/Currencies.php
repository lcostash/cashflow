<?php

namespace App\Livewire\Currencies;

use App\Models\Currency as CurrencyModel;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Currencies extends Component
{
    use WithPagination;
    public Currency $currency;

    public function add()
    {
        $this->authorize('create');
        $this->dispatch(
            'init',
            currency: null,
            heading: __('Add Currency'),
            subheading: __('Create a new currency for your financial records.')
        );
    }

    public function edit(Currency $currency)
    {
        $this->authorize('update', $currency);
        $this->dispatch(
            'init',
            currency: $currency,
            heading: __('Edit Currency'),
            subheading: __('Edit the data for the selected currency.')
        );
    }

    public function confirm(Currency $currency)
    {
        $this->authorize('delete', $currency);
        $this->currency = $currency;
        Flux::modal('confirm')->show();
    }

    public function delete()
    {
        $this->authorize('delete', $this->currency);
        CurrencyModel::where(['id' => $this->currency->id, 'user_id' => Auth::user()->id])->delete();

        $this->reset();
        Flux::modal('confirm')->close();
        session()->flash('success', __('Currency successfully deleted.'));
        $this->redirectRoute('currencies', navigate: true);
    }

    public function render()
    {
        $currencies = CurrencyModel::query()
            ->where(['user_id' => Auth::user()->id])
            ->orderBy('code')
            ->paginate(10);
        foreach ($currencies as $currency) {
            $this->authorize('view', [Auth::user(), $currency]);
        }
        return view('livewire.currencies.currencies', [
            'currencies' => $currencies,
        ]);
    }
}
