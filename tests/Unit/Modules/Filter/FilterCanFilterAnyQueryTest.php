<?php

namespace Tests\Unit\Modules\Filter;

use App\Modules\FilterManager\Mock\OnlyForTestingFilter;
use Tests\TestCase;
use App\Modules\FilterManager\FilterManager;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Modules\FilterManager\Filter\FilterableDTO;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Search\MakeSearchingDTO;
use Illuminate\Database\Eloquent\Builder;
use Mockery;

class FilterCanFilterAnyQueryTest extends TestCase
{
    public function test_can_use_filter_manager_for_filtering_database_queries(): void
    {
        // Mock the dependencies
        $mockFilter = Mockery::mock(OnlyForTestingFilter::class);
        $mockQuery = Mockery::mock(Builder::class);

        // Prepare some mock data
        $filterableDTOs = [
            new FilterableDTO('name', 'John'),
            new FilterableDTO('age', 30),
        ];
        $sortableDTOs = [
            new MakeSortingDTO('created_at', 'asc'),
        ];
        $comparableDTOs = [
            new MakeComparingDTO('salary', '>', 50000),
        ];
        $searchableDTO = new MakeSearchingDTO('John Doe');

        // aggregate the filters
        $aggregator = new FiltersAggregator;
        $aggregator->addFilter($filterableDTOs[0]);
        $aggregator->addFilter($filterableDTOs[1]);
        $aggregator->addSorting($sortableDTOs[0]);
        $aggregator->addComparing($comparableDTOs[0]);
        $aggregator->addSearching($searchableDTO);

        // Set expectations on the filter mock
        $mockFilter->shouldReceive('name')->with($mockQuery, 'John')->once();
        $mockFilter->shouldReceive('age')->with($mockQuery, 30)->once();
        $mockFilter->shouldReceive('sortCreatedAt')->with($mockQuery, $sortableDTOs[0])->once();
        $mockFilter->shouldReceive('compareSalary')->with($mockQuery, $comparableDTOs[0])->once();
        $mockFilter->shouldReceive('search')->with($mockQuery, $searchableDTO)->once();

        // Call the apply method and assert the query builder returned
        $filterManager = new FilterManager;
        $resultQuery = $filterManager->apply($mockQuery, $mockFilter, $aggregator);

        // Assert that the apply method returns the query builder
        $this->assertInstanceOf(Builder::class, $resultQuery);
    }
}

