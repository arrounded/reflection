<?php
namespace Arrounded\Reflection;

use Arrounded\TestCases\ArroundedTestCase;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Mockery;

class ReflectorTest extends ReflectionTestCase
{
    /**
     * @type Reflector
     */
    protected $reflector;

    public function setUp()
    {
        $container = new Container();
        $container['files'] = new Filesystem();

        $this->reflector = new Reflector($container);
    }

    public function testCanQualifyClass()
    {
        $this->assertEquals('Foobar', $this->reflector->qualifyClass('Foobar'));
        $this->assertEquals('Composers\Foobar', $this->reflector->qualifyClass('Foobar', 'Composers'));

        $this->reflector->setRootNamespace('Arrounded');
        $this->assertEquals('Arrounded\Foobar', $this->reflector->qualifyClass('Foobar'));
        $this->assertEquals('Arrounded\Composers\Foobar', $this->reflector->qualifyClass('Foobar', 'Composers'));

        $this->reflector->setNamespaces(['Composers' => 'Http']);
        $this->assertEquals('Arrounded\Foobar', $this->reflector->qualifyClass('Foobar'));
        $this->assertEquals('Arrounded\Http\Composers\Foobar', $this->reflector->qualifyClass('Foobar', 'Composers'));

        $this->reflector->setNamespaces(['Composers' => null]);
        $this->assertEquals('Arrounded\Composers\Foobar', $this->reflector->qualifyClass('Foobar', 'Composers'));
    }

    public function testCanGetFirstExistingClass()
    {
        $this->assertEquals('Arrounded\Reflection\Reflector', $this->reflector->getFirstExistingClass('Arrounded\Reflection\Reflector'));
        $this->assertEquals('Arrounded\Reflection\Reflector', $this->reflector->getFirstExistingClass([
            'Foo\Bar',
            'Arrounded\Reflection\Reflector'
        ]));
    }

    public function testCanGetModelService()
    {
        $this->reflector->setNamespace('Arrounded');
        $this->reflector->setNamespaces(['Repositories' => 'Reflection']);

        $repository = $this->reflector->getModelService('Upload', 'Repositories');
        $this->assertEquals('Arrounded\Reflection\Repositories\UploadsRepository', $repository);
    }

    public function testCanGetFolder()
    {
        $this->app['files'] = Mockery::mock('Illuminate\Filesystem\Filesystem', ['isDirectory' => true])->makePartial();

        $this->reflector->setNamespace('Arrounded');
        $this->app['path'] = __DIR__.'/../src';

        $folder = $this->reflector->getFolder('Facades');
        $this->assertEquals(__DIR__.'/../src/Facades', $folder);

        $folder = $this->reflector->getFolder('Entities\Traits');
        $this->assertEquals(__DIR__.'/../src/Entities/Traits', $folder);

        $this->reflector->setNamespaces(['Traits' => 'Entities']);
        $folder = $this->reflector->getFolder('Traits');
        $this->assertEquals(__DIR__.'/../src/Entities/Traits', $folder);
    }
}
