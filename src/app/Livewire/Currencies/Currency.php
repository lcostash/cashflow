<?php

namespace App\Livewire\Currencies;

use App\Models\Currency as CurrencyModel;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class Currency extends Component
{
    public $heading;
    public $subheading;
    public $id;
    public $code;
    public $name;

    public function rules()
    {
        return [
            'code' => 'required|string|size:3|unique:currencies,code,' . ($this->id ?? 'NULL') . ',id',
            'name' => 'required|string|max:255',
        ];
    }

    #[On('init')]
    public function init($id = null, $heading = null, $subheading = null)
    {
        $this->id = $id;
        $this->heading = $heading;
        $this->subheading = $subheading;

        if (!is_null($this->id)) {
            $currency = CurrencyModel::findOrFail($this->id);
            $this->code = $currency->code;
            $this->name = $currency->name;
        }

        Flux::Modal('currency')->show();
    }

    public function save()
    {
        $this->validate();

        CurrencyModel::updateOrCreate(
            ['id' => $this->id ?? null],
            [
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
