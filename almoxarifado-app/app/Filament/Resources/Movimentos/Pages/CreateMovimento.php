<?php

namespace App\Filament\Resources\Movimentos\Pages;

use App\Filament\Resources\Movimentos\MovimentoResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produto;
use App\Models\Movimento;
use Filament\Notifications\Notificaton;

class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;
    /**
     * O que a beforeCreate faz?
     * Valida se há estoque suficiente antes de salvar a movimentação. Se o tipo for 
     * uma saída ('s') e a quantidade for maior que o estoque atual, o processo 
     * é interrompido e uma notificação de erro é exibida.
     * @param $data recebe os dados do produto
     * @param $produto recebe uma lista com os dados dos produtos pelo 
     * @param $quantidade - recebe o valor do campo quantidade do $produto anteriormente selecionado
     * @param $tipo - recebe o valor do campo do tipo $produto anteriormente selecionado
     * @return void
     */

    protected function beforeCreate(): void
    {
        // Recebe a lista de produtos
        $data = $this->data;

        // Selecionando o produto/qtd e tipo pelo id recebido na lista
        $produto = Produto::find($data['produto_id']);
        $quantidade = $data['quantidade'];
        $tipo = $data['tipo'];


        // Verificar se é uma saída e se o estoque é suficiente
        if ($tipo === 's' && $quantidade > $produto->estoque) {
            // Notificar o usuário sobre o estoque insuficiente
            Notification::make()
                ->danger()
                ->title('Estoque Insuficiente!')
                ->body("O estoque de '{$produto->nome}' é de amenas {$produto->estoque} unidade, mas você tentou retirar {$quantidade}.")
                ->send();

            $this->halt(); // Impede a criação do movimento
        }
    }

    protected function afterCreate(): void
    {
        $movimento = $this->getRecord();
        $produto = $movimento->$produto;

        if ($movimento->tipo === 'e') {
            $produto->increment('estoque', $movimento->quantidade);
        } else {
            $produto->decrement('estoque', $movimento->quantidade);
        }
    }
}
