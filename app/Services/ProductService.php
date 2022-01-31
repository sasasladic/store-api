<?php

namespace App\Services;

use App\Models\ProductOption;
use App\Repositories\OptionValueRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{

    private OptionValueRepositoryInterface $optionRepository;

    private ProductRepositoryInterface $productRepository;

    /**
     * CategoryController constructor.
     * @param OptionValueRepositoryInterface $optionRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        OptionValueRepositoryInterface $optionRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->optionRepository = $optionRepository;
        $this->productRepository = $productRepository;
    }

    public function getRequestVariantOptionValues(array $variantValues, int $productId, int $userId): array
    {
        $optionValues = [];
        foreach ($variantValues as $variantValue) {
            //Chekiraj da li postoji vec veza
            $this->productRepository->createProductOptionRelation($productId, $variantValue['option_id'], $userId);

            // if (!$optionValue) - Not possible, because it's predefined and selected from dropdown
            $optionValue = $this->optionRepository->getOptionValueRelation($variantValue['option_id'], $variantValue['value']);

            $optionValues[$optionValue->id] = [
                'created_by' => $userId,
                'updated_by' => $userId
            ];
        }

        return $optionValues;
    }
}
