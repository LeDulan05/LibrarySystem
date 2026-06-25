<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrapeBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-books {--count=5 : Number of books per category to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch books from Google Books API and seed the database with real covers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $genres = [
            'Programming',
            'Artificial Intelligence',
            'Database',
            'Fiction',
            'History',
            'Geography',
            'Biology',
            'Science',
            'Business',
            'Philosophy',
            'Fantasy',
            'Mystery',
            'Romance',
            'Thriller',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Psychology',
            'Sociology',
            'Politics',
            'Art',
            'Music',
            'Cooking',
            'Travel',
            'Self Help',
            'Health',
            'Sports',
            'Biography',
            'Comics'
        ];

        $count = $this->option('count');
        $this->info("Starting book scrape. Target: {$count} books per genre.");

        // Ensure the covers directory exists
        if (!Storage::disk('public')->exists('covers')) {
            Storage::disk('public')->makeDirectory('covers');
        }

        foreach ($genres as $genre) {
            $this->info("Fetching books for genre: {$genre}");
            
            // Get category
            $category = Category::firstOrCreate(
                ['name' => $genre],
                ['description' => "Books related to {$genre}"]
            );

            // Fetch from OpenLibrary API
            $url = "https://openlibrary.org/search.json";
            try {
                $response = Http::timeout(30)->connectTimeout(30)->withoutVerifying()->get($url, [
                    'subject' => strtolower($genre),
                    'limit' => $count,
                    'language' => 'eng',
                ]);

                if (!$response->successful()) {
                    $this->error("Failed to fetch data for {$genre}");
                    $this->error($response->body());
                    continue;
                }
            } catch (\Exception $e) {
                $this->error("Exception while fetching data for {$genre}: " . $e->getMessage());
                continue;
            }

            $items = $response->json('docs');
            
            if (!$items) {
                $this->warn("No books found for {$genre}");
                continue;
            }

            foreach ($items as $item) {
                $title = $item['title'] ?? null;
                $authors = $item['author_name'] ?? ['Unknown Author'];
                $author = implode(', ', $authors);
                $publishers = $item['publisher'] ?? ['Unknown Publisher'];
                $publisher = $publishers[0] ?? 'Unknown Publisher';
                
                $year_published = $item['first_publish_year'] ?? 2000;
                $description = "A comprehensive book about {$title} by {$author}. Perfect for students and professionals interested in {$genre}.";
                
                // Get ISBN
                $isbn = null;
                $isbns = $item['isbn'] ?? [];
                if (count($isbns) > 0) {
                    $isbn = $isbns[0];
                } else {
                    $isbn = '978' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
                }

                // Check if book already exists
                if (Book::where('isbn', $isbn)->orWhere('title', $title)->exists()) {
                    continue;
                }

                // Handle Cover Image Download
                $book_cover = null;
                $cover_i = $item['cover_i'] ?? null;
                
                if ($cover_i) {
                    $thumbnailUrl = "https://covers.openlibrary.org/b/id/{$cover_i}-L.jpg";
                    
                    try {
                        $imageContents = Http::withoutVerifying()->get($thumbnailUrl)->body();
                        $filename = Str::slug($title) . '-' . uniqid() . '.jpg';
                        
                        Storage::disk('public')->put('covers/' . $filename, $imageContents);
                        $book_cover = 'covers/' . $filename;
                    } catch (\Exception $e) {
                        $this->warn("Failed to download image for {$title}");
                    }
                }

                // Invent realistic copies
                $total_copies = mt_rand(1, 5);
                $available_copies = mt_rand(0, $total_copies);

                // Create Book
                Book::create([
                    'title' => Str::limit($title, 250),
                    'author' => Str::limit($author, 250),
                    'isbn' => Str::limit($isbn, 250),
                    'category_id' => $category->id,
                    'publisher' => Str::limit($publisher, 250),
                    'year_published' => $year_published,
                    'description' => $description,
                    'book_cover' => $book_cover,
                    'total_copies' => $total_copies,
                    'available_copies' => $available_copies,
                ]);

                $this->line("   -> Added: {$title}");
            }
        }

        $this->info("Scraping completed!");
    }
}
