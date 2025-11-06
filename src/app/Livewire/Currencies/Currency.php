<?php

namespace App\Livewire\Currencies;

use App\Models\Currency as CurrencyModel;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Currency extends Component
{
    public $heading;
    public $subheading;
    public Currency|null $currency;
    public $code;
    public $name;

    public function rules()
    {
        return [
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'code' => 'required|string|size:3|unique:currencies,code,' . ($this->currency?->id ?? 'NULL') . ',id',
            'name' => 'required|string|max:255',
        ];
    }

    #[On('init')]
    public function init(Currency|null $currency = null, $heading = null, $subheading = null)
    {
        $this->currency = $currency;
        $this->heading = $heading;
        $this->subheading = $subheading;

        if ($this->currency instanceof CurrencyModel) {
            $currency = CurrencyModel::findOrFail($this->currency->id);
            $this->code = $currency->code;
            $this->name = $currency->name;
        }

        Flux::Modal('currency')->show();
    }

    public function save()
    {
        if ($this->currency) {
            $this->authorize('update', $this->currency);
        } else {
            $this->authorize('create');
        }
        $this->validate();

        CurrencyModel::updateOrCreate(
            ['id' => $this->currency->id ?? null],
            [
                'user' => Auth::user(),
                'code' => strtoupper($this->code),
                'name' => $this->name,
            ]
        );

        $this->reset();
        Flux::modal('currency')->close();
        session()->flash('success', 'Currency successfully saved.');
        $this->redirectRoute('currencies', navigate: true);
    }

    public function render()
    {
        return view('livewire.currencies.currency');
    }
}
