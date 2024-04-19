<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Symfony\Component\Mime\Encoder\QpEncoder;

class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $builder, String $title){

        return $builder->where('title','LIKE',"%". $title."%");

    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ])->orderBy('reviews_count', 'desc');
    }
    public function scopeHighestRated(Builder $query , $from = null ,$to = null)
    {
        return $query->withAvg([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q,$from,$to)
        ],'rating')->orderBy('reviews_Avg_rating','desc');
    }

    public function scopeMinReviews(Builder $query ,int $minReviews) :Builder|QueryBuilder
    {
        return $query->having('reviews_count','>=',$minReviews);
    }

    private function dateRangeFilter(Builder $query , $from, $to){

        if($from and !$to){
            $query->where('created_at','>=', $from);
        }elseif(!$from && $to){
            $query->where('created_at','<=', $to);
        }elseif($from && $to){
            $query->whereBetween('created_at',[$from,$to]);
        }
    }

    public function scopePopularLastMonth(Builder $query) :Builder|QueryBuilder
    {
        return $query->popular(now()->subMonth(),now())
            ->HighestRated(now()->subMonth(),now())
            ->minreviews(2);
    }

    public function scopePopularLast6Months(Builder $query) :Builder|QueryBuilder
    {
        return $query->popular(now()->subMonths(6),now())
            ->HighestRated(now()->subMonths(6),now())
            ->minreviews(5);
    }

    public function scopeHighestRatedLastmonth(Builder $query) :Builder|QueryBuilder
    {
        return $query->HighestRated(now()->subMonth(),now())
            ->popular(now()->subMonth(),now())
            ->minreviews(2);
    }
    public function scopeHighestRatedLast6months(Builder $query) :Builder|QueryBuilder
    {
        return $query->HighestRated(now()->subMonths(6),now())
            ->popular(now()->subMonths(6),now())
            ->minreviews(5);
    }
}
