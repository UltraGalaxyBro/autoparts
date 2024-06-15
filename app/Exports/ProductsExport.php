<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Pegando todos os produtos
        $productsCollection = Product::with(['automaker', 'brand', 'category'])->get();

        // Calculando o custo total e o preço total do estoque
        //$totalCost = $productsCollection->sum(function ($product) {
        //    return $product->cost * $product->total_stock;
        //});

        //$totalPrice = $productsCollection->sum(function ($product) {
        //    return $product->price * $product->total_stock;
        //});

        // Mapeando os produtos para o formato desejado
        $products = $productsCollection->map(function ($product) {
            return [
                'DESCRIÇÃO/NOME' => $product->name,
                'CATEGORIA' => $product->category->name,
                'MONTADORA' => $product->automaker->name,
                'MARCA' => $product->brand->name,
                'CÓDIGO SISTEMA' => $product->inside_code,
                'CÓDIGO ORIGINAL' => $product->original_code,
                'MODELO/CÓDIGO MARCA' => $product->brand_code,
                'NCM' => $product->ncm,
                'CUSTO UNIT.' => number_format($product->cost, 2, ',', '.'),
                'PREÇO UNIT. (P/E-COMMERCE)' => number_format($product->price, 2, ',', '.'),
                'QTD.' => $product->total_stock,
                'PRATELEIRA(S)' => $product->indoor_location,
                'SIMILARES (AVULSO)' => $product->cross_code,
            ];
        });

        return $products;
    }

    public function headings(): array
    {
        return [
            'DESCRIÇÃO/NOME',
            'CATEGORIA',
            'MONTADORA',
            'MARCA',
            'CÓDIGO SISTEMA',
            'CÓDIGO ORIGINAL',
            'MODELO/CÓDIGO MARCA',
            'NCM',
            'CUSTO UNIT.',
            'PREÇO UNIT. (P/E-COMMERCE)',
            'QTD.',
            'PRATELEIRA(S)',
            'SIMILARES (AVULSO)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '114C8D'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Centraliza os dados
        $sheet->getStyle('A2:M' . ($sheet->getHighestRow()))->getAlignment()->applyFromArray([
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ]);
    }
}
