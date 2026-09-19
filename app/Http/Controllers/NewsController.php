<?php

namespace App\Http\Controllers;

class NewsController extends Controller
{
    private function getAllNews()
    {
        return [
            [
                'id' => 1,
                'title' => 'HP Launches New AI-Powered LaserJet Pro',
                'excerpt' => 'HP announces a new generation of LaserJet Pro printers equipped with AI technology to improve print quality and reduce ink consumption.',
                'content' => 'HP has announced a new generation of LaserJet Pro printers with AI capabilities. The new printers can analyse documents and automatically optimise print quality, reducing ink consumption by up to 30%. They also support cloud printing and remote control via smartphone app.',
                'category' => 'Product News',
                'date' => '2026-04-15',
                'image' => 'news1',
                'author' => 'urca Team',
                'views' => 1240,
            ],
            [
                'id' => 2,
                'title' => 'Epson Announces Major EcoTank Lineup Expansion',
                'excerpt' => 'Epson adds 8 new models to its popular EcoTank line, with significant improvements in speed and quality.',
                'content' => 'Epson has announced a major expansion of its EcoTank product line. The new models feature 40% faster print speeds compared to the previous generation, while maintaining the low printing costs the line is known for. The new models also support wireless printing and smartphone apps.',
                'category' => 'Company News',
                'date' => '2026-04-10',
                'image' => 'news2',
                'author' => 'urca Team',
                'views' => 876,
            ],
            [
                'id' => 3,
                'title' => 'urca Opens New Branch in Alexandria',
                'excerpt' => 'As part of its expansion plan, urca opens a new branch in Alexandria to serve customers on the North Coast.',
                'content' => 'We are pleased to announce the opening of our new branch in Alexandria. The new branch is located in the heart of the city and provides all our services including product sales, maintenance, and technical support. We aim through this expansion to provide better service to our customers on the North Coast.',
                'category' => 'Company News',
                'date' => '2026-04-05',
                'image' => 'news3',
                'author' => 'urca Management',
                'views' => 2100,
            ],
            [
                'id' => 4,
                'title' => 'Canon Launches PIXMA G7070 All-in-One Printer',
                'excerpt' => 'A new Canon printer combining printing, scanning, copying, and faxing in one economical device.',
                'content' => 'Canon has launched its new PIXMA G7070 printer that combines four functions in one device. The printer features a large ink tank capable of printing thousands of pages, with support for wireless printing and smartphone apps. The competitive price makes it an ideal choice for small businesses.',
                'category' => 'Product News',
                'date' => '2026-03-28',
                'image' => 'news4',
                'author' => 'urca Team',
                'views' => 654,
            ],
            [
                'id' => 5,
                'title' => 'Big Deals on All Printers — Up to 40% Off',
                'excerpt' => 'urca offers discounts of up to 40% on all printers.',
                'content' => 'urca is offering exceptional deals on all printers and products. Discounts reach up to 40% on HP, Canon, Epson, and Brother printers. Offers are valid with free delivery across Egypt.',
                'category' => 'Offers & Deals',
                'date' => '2026-03-20',
                'image' => 'news5',
                'author' => 'Marketing Team',
                'views' => 3450,
            ],
            [
                'id' => 6,
                'title' => 'Brother Wins Best Office Printer Award 2026',
                'excerpt' => 'Brother wins the Best Office Printer award from TechReview magazine for 2026.',
                'content' => 'Brother has won the Best Office Printer award from TechReview magazine for 2026. The award was given to the HL-L9310CDW for its exceptional quality, high reliability, and low running costs. urca is proud to be the official distributor of Brother products in Egypt.',
                'category' => 'Awards',
                'date' => '2026-03-15',
                'image' => 'news6',
                'author' => 'urca Team',
                'views' => 987,
            ],
        ];
    }

    public function index()
    {
        $news = $this->getAllNews();
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $allNews = $this->getAllNews();
        $item = collect($allNews)->firstWhere('id', (int)$id);

        if (!$item) {
            abort(404);
        }

        $related = collect($allNews)
            ->where('id', '!=', $item['id'])
            ->take(3)
            ->values()
            ->toArray();

        return view('news.show', compact('item', 'related'));
    }
}
