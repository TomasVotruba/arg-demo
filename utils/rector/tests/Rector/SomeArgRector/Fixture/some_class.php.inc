<?php

namespace Utils\Rector\Tests\Rector\SomeArgRector\Fixture;

class SomeClass
{
    public function someMethod()
    {
        $anotherClass = new AnotherClass();
        $anotherClass->someMethod()->assertSnapshot(inlineNewlines: true);
    }
}

class AnotherClass
{
    public function someMethod()
    {
        return 'printed result';
    }
}

?>
-----
<?php

namespace Utils\Rector\Tests\Rector\SomeArgRector\Fixture;

// @todo fill code after

?>
