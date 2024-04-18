<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;


class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $builder, String $tilte){

        return $builder->where('title','LIKE','%sit%');

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

    public function scopeMinreviews(Builder $query ,int $minReviews) :Builder|QueryBuilder
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

}

