<?php
namespace Arrounded\Reflection\Entities\Traits;

use Arrounded\Reflection\Dummies\DummyReflectionModel;
use Arrounded\Reflection\ReflectionTestCase;

class ReflectionModelTest extends ReflectionTestCase
{
    /**
     * @var DummyReflectionModel
     */
    protected $model;

    public function setUp()
    {
        $this->model = new DummyReflectionModel([
            'user_id' => 1,
        ]);
    }

    public function testCanGetIdentifier()
    {
        $model = new DummyReflectionModel(['id' => 1]);
        $this->assertEquals(1, $model->getIdentifier());

        $model = new DummyReflectionModel(['id' => 1, 'slug' => 'foobar']);
        $this->assertEquals('foobar', $model->getIdentifier());
    }

    public function testCanGetClass()
    {
        $this->assertEquals(DummyReflectionModel::class, $this->model->getClass());
    }

    public function testCanGetClassBasename()
    {
        $this->assertEquals('DummyReflectionModel', $this->model->getClassBasename());
    }

    public function testCanCheckIfHasTrait()
    {
        $this->assertTrue($this->model->hasTrait(ReflectionModel::class));
    }
}
