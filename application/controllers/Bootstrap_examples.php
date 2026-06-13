<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bootstrap_examples extends CI_Controller {

    public function index()
    {
        $data = [
            'page_title' => 'Bootstrap Examples',
            'active_nav' => 'bootstrap_examples',
            'examples' => $this->get_examples(),
        ];

        $this->load->view('bootstrap_examples/index', $data);
    }

    public function show($slug = '')
    {
        $examples = $this->get_examples_indexed();

        if ($slug === '' || !isset($examples[$slug])) {
            show_404();
            return;
        }

        $this->load->view('bootstrap_examples/examples/' . $slug);
    }

    private function get_examples()
    {
        $paths = glob(APPPATH . 'views/bootstrap_examples/examples/*.php');
        $examples = [];

        foreach ($paths as $path) {
            $slug = basename($path, '.php');
            $isRtl = substr($slug, -4) === '-rtl';
            $examples[] = [
                'slug' => $slug,
                'title' => $this->format_title($slug),
                'is_rtl' => $isRtl,
                'url' => site_url('bootstrap_examples/show/' . $slug),
            ];
        }

        usort($examples, function ($left, $right) {
            return strcmp($left['title'], $right['title']);
        });

        return $examples;
    }

    private function get_examples_indexed()
    {
        $indexed = [];

        foreach ($this->get_examples() as $example) {
            $indexed[$example['slug']] = $example;
        }

        return $indexed;
    }

    private function format_title($slug)
    {
        $label = str_replace('-rtl', ' rtl', $slug);
        $label = str_replace('-', ' ', $label);

        return ucwords($label);
    }
}
