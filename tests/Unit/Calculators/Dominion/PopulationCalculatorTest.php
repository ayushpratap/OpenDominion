<?php

namespace OpenDominion\Tests\Unit\Calculators\Dominion;

use Mockery as m;
use Mockery\Mock;
use OpenDominion\Calculators\Dominion\ImprovementCalculator;
use OpenDominion\Calculators\Dominion\LandCalculator;
use OpenDominion\Calculators\Dominion\PopulationCalculator;
use OpenDominion\Calculators\Dominion\SpellCalculator;
use OpenDominion\Helpers\BuildingHelper;
use OpenDominion\Helpers\UnitHelper;
use OpenDominion\Models\Dominion;
use OpenDominion\Services\Dominion\Queue\ConstructionQueueService;
use OpenDominion\Services\Dominion\Queue\TrainingQueueService;
use OpenDominion\Tests\AbstractBrowserKitTestCase;

/**
 * @coversDefaultClass \OpenDominion\Calculators\PopulationCalculator
 */
class PopulationCalculatorTest extends AbstractBrowserKitTestCase
{
    /** @var Mock|Dominion */
    protected $dominion;

    /** @var Mock|ConstructionQueueService */
    protected $constructionQueueService;

    /** @var Mock|ImprovementCalculator */
    protected $improvementsCalculator;

    /** @var Mock|LandCalculator */
    protected $landCalculator;

    /** @var Mock|SpellCalculator */
    protected $spellCalculator;

    /** @var Mock|TrainingQueueService */
    protected $trainingQueueService;

    /** @var Mock|PopulationCalculator */
    protected $sut;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->dominion = m::mock(Dominion::class);

        $this->sut = m::mock(PopulationCalculator::class, [
            $this->app->make(BuildingHelper::class),
            $this->constructionQueueService = m::mock(ConstructionQueueService::class),
            $this->improvementsCalculator = m::mock(ImprovementCalculator::class),
            $this->landCalculator = m::mock(LandCalculator::class),
            $this->spellCalculator = m::mock(SpellCalculator::class),
            $this->trainingQueueService = m::mock(TrainingQueueService::class),
            $this->app->make(UnitHelper::class)
        ])->makePartial();
    }

    public function testGetPopulation()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationMilitary()
    {
        $this->markTestIncomplete();
    }

    public function testGetMaxPopulation()
    {
        $this->markTestIncomplete();
    }

    public function testGetMaxPopulationRaw()
    {
        $this->markTestIncomplete();
    }

    public function testGetMaxPopulationMultiplier()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationBirth()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationBirthRaw()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationBirthMultiplier()
    {
        $this->markTestIncomplete();
    }

    /**
     * @dataProvider getPopulationPeasantGrowthProvider
     */
    public function testGetPopulationPeasantGrowth(
        /** @noinspection PhpDocSignatureInspection */
        int $expected,
        int $peasants,
        int $drafteeGrowth,
        int $maxPopulation,
        int $population,
        int $populationBirth
    ) {
        $this->dominion->shouldReceive('getAttribute')->with('peasants')->andReturn($peasants);
        $this->sut->shouldReceive('getPopulationDrafteeGrowth')->andReturn($drafteeGrowth);
        $this->sut->shouldReceive('getMaxPopulation')->andReturn($maxPopulation);
        $this->sut->shouldReceive('getPopulation')->andReturn($population);
        $this->sut->shouldReceive('getPopulationBirth')->andReturn($populationBirth);

        $this->assertEquals(
            $expected,
            $this->sut->getPopulationPeasantGrowth($this->dominion),
            sprintf(
                "Population: %s/%s\nBirth: %s\nDraftee Growth: %s",
                $population,
                $maxPopulation,
                $populationBirth,
                $drafteeGrowth
            )
        );
    }

    public function getPopulationPeasantGrowthProvider()
    {
        return [
            [39, 1300, 0, 2358, 1600, 39],
            [64, 1853, 0, 2563, 2449, 64],
        ];
    }

    public function testGetPopulationDrafteeGrowth()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationPeasantPercentage()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationMilitaryMaxTrainable()
    {
        $this->markTestIncomplete();
    }

    public function testGetEploymentJobs()
    {
        $this->markTestIncomplete();
    }

    public function testGetPopulationEmployed()
    {
        $this->markTestIncomplete();
    }

    public function testGetEmploymentPercentage()
    {
        $this->markTestIncomplete();
    }
}
