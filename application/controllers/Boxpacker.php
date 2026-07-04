<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use DVDoug\BoxPacker\Box;
use DVDoug\BoxPacker\Item;
use DVDoug\BoxPacker\Packer;

class Boxpacker extends CI_Controller
{
    public function index()
    {
        $boxChoices = $this->getBoxChoices();
        $packRequests = $this->getGettingStartedPackRequests();
        $packedBoxes = $this->runPack($boxChoices, $packRequests);

        $csvPackRequests = $this->getCsvPackRequests();
        $csvPackedBoxes = $this->runPack($boxChoices, $csvPackRequests);

        $this->load->view('boxpacker/index', [
            'packed_boxes' => $packedBoxes,
            'pack_requests' => $packRequests,
            'csv_packed_boxes' => $csvPackedBoxes,
            'csv_pack_requests' => $csvPackRequests,
            'box_choices' => $boxChoices,
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
        $boxes = [];

        foreach ($this->getBoxDefinitions() as $definition) {
            $boxes[] = $this->createBox($definition);
        }

        return $boxes;
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
            $rawQuantity = isset($quantities[$key]) ? $quantities[$key] : $definition['default_qty'];
            $quantity = max(0, (int) $rawQuantity);

            $requests[] = [
                'key' => $key,
                'item' => $this->createItem($definition),
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
            'powerbank' => [
                'title' => 'Powerbank',
                'comment' => 'Portable charging powerbank.',
                'width' => 110,
                'length' => 70,
                'depth' => 20,
                'weight_g' => 220,
                'keep_flat' => FALSE,
                'product_code' => 'TEST-POWERBANK-001',
                'default_qty' => 100,
            ],
            'magsafe_iphone_17_charger' => [
                'title' => 'Magsafe iPhone 17 Charger',
                'comment' => 'MagSafe-compatible wireless charger for iPhone 17.',
                'width' => 95,
                'length' => 95,
                'depth' => 15,
                'weight_g' => 140,
                'keep_flat' => TRUE,
                'product_code' => 'TEST-MAGSAFE-IPHONE-17-001',
                'default_qty' => 100,
            ],
            'bagpack' => [
                'title' => 'Bagpack',
                'comment' => 'Everyday backpack for carry and storage.',
                'width' => 450,
                'length' => 330,
                'depth' => 120,
                'weight_g' => 900,
                'keep_flat' => FALSE,
                'product_code' => 'TEST-BAGPACK-001',
                'default_qty' => 70,
            ],
            'laptop_stand' => [
                'title' => 'Laptop Stand',
                'comment' => 'Foldable laptop stand for desk use.',
                'width' => 320,
                'length' => 250,
                'depth' => 25,
                'weight_g' => 160,
                'keep_flat' => FALSE,
                'product_code' => 'TEST-LAPTOP-STAND-001',
                'default_qty' => 5,
            ],
        ];
    }

    private function getBoxDefinitions()
    {
        return [
            [
                'reference' => 'UPS Small Cube',
                'outer_width' => 156,
                'outer_length' => 156,
                'outer_depth' => 156,
                'empty_weight' => 12,
                'inner_width' => 152,
                'inner_length' => 152,
                'inner_depth' => 152,
                'max_weight' => 5000,
            ],
            [
                'reference' => 'UPS Small Rectangle',
                'outer_width' => 207,
                'outer_length' => 156,
                'outer_depth' => 131,
                'empty_weight' => 14,
                'inner_width' => 203,
                'inner_length' => 152,
                'inner_depth' => 127,
                'max_weight' => 5000,
            ],
            [
                'reference' => 'UPS Medium Cube',
                'outer_width' => 207,
                'outer_length' => 207,
                'outer_depth' => 207,
                'empty_weight' => 18,
                'inner_width' => 203,
                'inner_length' => 203,
                'inner_depth' => 203,
                'max_weight' => 7000,
            ],
            [
                'reference' => 'UPS Medium Rectangle',
                'outer_width' => 309,
                'outer_length' => 233,
                'outer_depth' => 156,
                'empty_weight' => 20,
                'inner_width' => 305,
                'inner_length' => 229,
                'inner_depth' => 152,
                'max_weight' => 10000,
            ],
            [
                'reference' => 'UPS Flat Box',
                'outer_width' => 309,
                'outer_length' => 233,
                'outer_depth' => 55,
                'empty_weight' => 12,
                'inner_width' => 305,
                'inner_length' => 229,
                'inner_depth' => 51,
                'max_weight' => 3000,
            ],
            [
                'reference' => 'UPS Long Flat Box',
                'outer_width' => 334,
                'outer_length' => 283,
                'outer_depth' => 55,
                'empty_weight' => 14,
                'inner_width' => 330,
                'inner_length' => 279,
                'inner_depth' => 51,
                'max_weight' => 3000,
            ],
            [
                'reference' => 'FedEx Small Box',
                'outer_width' => 280,
                'outer_length' => 42,
                'outer_depth' => 318,
                'empty_weight' => 16,
                'inner_width' => 276,
                'inner_length' => 38,
                'inner_depth' => 314,
                'max_weight' => 3000,
            ],
            [
                'reference' => 'FedEx Medium Box',
                'outer_width' => 296,
                'outer_length' => 64,
                'outer_depth' => 341,
                'empty_weight' => 18,
                'inner_width' => 292,
                'inner_length' => 60,
                'inner_depth' => 337,
                'max_weight' => 3000,
            ],
            [
                'reference' => 'FedEx Large Box',
                'outer_width' => 458,
                'outer_length' => 318,
                'outer_depth' => 80,
                'empty_weight' => 24,
                'inner_width' => 454,
                'inner_length' => 314,
                'inner_depth' => 76,
                'max_weight' => 12000,
            ],
            [
                'reference' => 'Backpack Carton',
                'outer_width' => 524,
                'outer_length' => 424,
                'outer_depth' => 244,
                'empty_weight' => 30,
                'inner_width' => 520,
                'inner_length' => 420,
                'inner_depth' => 240,
                'max_weight' => 20000,
            ],
        ];
    }

    private function createBox($definition)
    {
        return new BoxpackerExampleBox(
            $definition['reference'],
            $definition['outer_width'],
            $definition['outer_length'],
            $definition['outer_depth'],
            $definition['empty_weight'],
            $definition['inner_width'],
            $definition['inner_length'],
            $definition['inner_depth'],
            $definition['max_weight']
        );
    }

    private function createItem($definition)
    {
        return new BoxpackerExampleItem(
            $definition['title'],
            $definition['width'],
            $definition['length'],
            $definition['depth'],
            $definition['weight_g'],
            $definition['keep_flat']
        );
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
