<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use DVDoug\BoxPacker\Box;
use DVDoug\BoxPacker\Item;
use DVDoug\BoxPacker\Packer;

class Boxpacker extends CI_Controller
{
    public function index()
    {
        $packRequests = $this->getGettingStartedPackRequests();
        $packedBoxes = $this->runPack($this->getBoxChoices(), $packRequests);

        $csvPackRequests = $this->getCsvPackRequests();
        $csvPackedBoxes = $this->runPack($this->getRewardsBoxChoices(), $csvPackRequests);

        $this->load->view('boxpacker/index', [
            'packed_boxes' => $packedBoxes,
            'pack_requests' => $packRequests,
            'csv_packed_boxes' => $csvPackedBoxes,
            'csv_pack_requests' => $csvPackRequests,
        ]);
    }

    private function runPack($boxes, $packRequests)
    {
        $packer = new Packer();

        foreach ($boxes as $box) {
            $packer->addBox($box);
        }

        foreach ($packRequests as $request) {
            if ($request['qty'] < 1) {
                continue;
            }

            $packer->addItem($request['item'], $request['qty']);
        }

        return $packer->pack();
    }

    private function getBoxChoices()
    {
        return [
            new BoxpackerExampleBox('Le petite box', 300, 300, 10, 10, 296, 296, 8, 1000),
            new BoxpackerExampleBox('Le grande box', 3000, 3000, 100, 100, 2960, 2960, 80, 10000),
        ];
    }

    private function getRewardsBoxChoices()
    {
        return [
            new BoxpackerExampleBox('Rewards Small Carton', 320, 220, 120, 120, 300, 200, 100, 1500),
            new BoxpackerExampleBox('Rewards Medium Carton', 420, 320, 180, 180, 400, 300, 160, 4000),
            new BoxpackerExampleBox('Rewards Large Carton', 520, 420, 240, 250, 500, 400, 220, 8000),
        ];
    }

    private function getGettingStartedPackRequests()
    {
        return [
            [
                'item' => new BoxpackerExampleItem('Item 1', 250, 250, 12, 200, TRUE),
                'qty' => 1,
            ],
            [
                'item' => new BoxpackerExampleItem('Item 2', 250, 250, 12, 200, TRUE),
                'qty' => 2,
            ],
            [
                'item' => new BoxpackerExampleItem('Item 3', 250, 250, 24, 200, FALSE),
                'qty' => 1,
            ],
        ];
    }

    private function getCsvPackRequests()
    {
        $definitions = $this->getCsvProductDefinitions();
        $quantities = $this->input->get('csv_qty');

        if (! is_array($quantities)) {
            $quantities = [];
        }

        $requests = [];

        foreach ($definitions as $key => $definition) {
            $rawQuantity = isset($quantities[$key]) ? $quantities[$key] : 1;
            $quantity = max(0, (int) $rawQuantity);

            $requests[] = [
                'key' => $key,
                'item' => new BoxpackerExampleItem(
                    $definition['title'],
                    $definition['width'],
                    $definition['length'],
                    $definition['depth'],
                    $definition['weight_g'],
                    $definition['keep_flat']
                ),
                'qty' => $quantity,
                'product_code' => $definition['product_code'],
                'comment' => $definition['comment'],
            ];
        }

        return $requests;
    }

    private function getCsvProductDefinitions()
    {
        return [
            'stress_reliever' => [
                'title' => 'Cool Round Stress Reliever',
                'comment' => 'Bounce, throw or squeeze this round stress ball.',
                'width' => 70,
                'length' => 70,
                'depth' => 70,
                'weight_g' => 20,
                'keep_flat' => FALSE,
                'product_code' => 'BROWREWARDS-US-030',
            ],
            'passport_wallet' => [
                'title' => 'Deluxe Recycled Passport Wallet',
                'comment' => 'Premium PU leather passport holder with anti-skimming protection.',
                'width' => 114,
                'length' => 146,
                'depth' => 12,
                'weight_g' => 60,
                'keep_flat' => TRUE,
                'product_code' => 'BROWREWARDS-US-048',
            ],
            'laptop_stand_speaker' => [
                'title' => 'Elevate Laptop Stand and Bluetooth Speaker',
                'comment' => 'Foldable laptop stand adjustable up to 35 degrees, with Bluetooth speaker.',
                'width' => 32,
                'length' => 248,
                'depth' => 213,
                'weight_g' => 160,
                'keep_flat' => FALSE,
                'product_code' => 'BROWREWARDS-US-044',
            ],
            'laptop_backpack' => [
                'title' => 'Greenway Recycled 15inch Laptop Backpack',
                'comment' => 'PU backpack with adjustable straps and multiple pockets.',
                'width' => 450,
                'length' => 330,
                'depth' => 120,
                'weight_g' => 910,
                'keep_flat' => FALSE,
                'product_code' => 'BROWREWARDS-US-047',
            ],
        ];
    }
}

class BoxpackerExampleBox implements Box
{
    private $reference;
    private $outerWidth;
    private $outerLength;
    private $outerDepth;
    private $emptyWeight;
    private $innerWidth;
    private $innerLength;
    private $innerDepth;
    private $maxWeight;

    public function __construct($reference, $outerWidth, $outerLength, $outerDepth, $emptyWeight, $innerWidth, $innerLength, $innerDepth, $maxWeight)
    {
        $this->reference = $reference;
        $this->outerWidth = $outerWidth;
        $this->outerLength = $outerLength;
        $this->outerDepth = $outerDepth;
        $this->emptyWeight = $emptyWeight;
        $this->innerWidth = $innerWidth;
        $this->innerLength = $innerLength;
        $this->innerDepth = $innerDepth;
        $this->maxWeight = $maxWeight;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getOuterWidth(): int
    {
        return $this->outerWidth;
    }

    public function getOuterLength(): int
    {
        return $this->outerLength;
    }

    public function getOuterDepth(): int
    {
        return $this->outerDepth;
    }

    public function getEmptyWeight(): int
    {
        return $this->emptyWeight;
    }

    public function getInnerWidth(): int
    {
        return $this->innerWidth;
    }

    public function getInnerLength(): int
    {
        return $this->innerLength;
    }

    public function getInnerDepth(): int
    {
        return $this->innerDepth;
    }

    public function getMaxWeight(): int
    {
        return $this->maxWeight;
    }
}

class BoxpackerExampleItem implements Item
{
    private $description;
    private $width;
    private $length;
    private $depth;
    private $weight;
    private $keepFlat;

    public function __construct($description, $width, $length, $depth, $weight, $keepFlat)
    {
        $this->description = $description;
        $this->width = $width;
        $this->length = $length;
        $this->depth = $depth;
        $this->weight = $weight;
        $this->keepFlat = $keepFlat;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getDepth(): int
    {
        return $this->depth;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getKeepFlat(): bool
    {
        return $this->keepFlat;
    }
}
