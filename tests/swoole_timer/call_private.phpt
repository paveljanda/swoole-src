--TEST--
swoole_timer: call private method
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php
require __DIR__ . '/../include/bootstrap.php';

class Test
{
    private static function foo() { }

    private function bar() { }
}

fork_exec(function () {
    swoole_timer_after(1, [Test::class, 'not_exist']);
});
fork_exec(function () {
    swoole_timer_after(1, [Test::class, 'foo']);
});
fork_exec(function () {
    swoole_timer_after(1, [new Test, 'bar']);
});

?>
--EXPECTF--
Fatal error: swoole_timer_after(): Function 'Test::not_exist' is not callable in %s/tests/swoole_timer/call_private.php on line 12

Fatal error: swoole_timer_after(): Function 'Test::foo' is not callable in %s/tests/swoole_timer/call_private.php on line 15

Fatal error: swoole_timer_after(): Function 'Test::bar' is not callable in %s/tests/swoole_timer/call_private.php on line 18
