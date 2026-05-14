<?php

namespace App\Filament\Resources\MovimentoResource\Pages;

use App\Models\Produto;
use App\Filament\Resources\MovimentoResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;

class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;
    protected function beforeCreate(): void
    {
        $data = $this->data;
        $produto = Produto::find($data['produto_id']);
        $quantidade = (int)$data['quantidade'];
        $tipo = $data['tipo'];

            if ($tipo === 'saida' && $quantidade> $produto->estoque){
                Notification::make()
                    ->title('Estoque insuficiente ')
                    ->body("Estoque insuficiente")
                    ->danger()
                    ->send();
                throw new Halt();
            }
    }

    protected function afterCreate(): void
    {
        // Runs after the form fielders 
        $movimento = $this->getRecord();
        $produto = $movimento->produto;
        if($movimento->tipo === 'entrada'){
            $produto->increment('estoque', $movimento->quantidade);
        }else{
            $produto->decrement('estoque', $movimento->quantidade);
        }
    }
}

