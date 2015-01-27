<?php


namespace Aac\Model;


class BoardTest extends \PHPUnit_Framework_TestCase
{

    protected $repo;


    protected function setUp()
    {
        parent::setUp();
        $repo = $this->getMockBuilder('Aac\Model\BoardRepositorySession') //cant use interface!!
        ->disableOriginalConstructor()
            ->getMock();
        $this->repo = $repo;


    }

    public function testCreateNewBoard()
    {

        $new_id = uniqid();

        $this->repo->expects($this->once())
            ->method('createNewBoard')
            ->willReturn($new_id);

        $board = new Board($this->repo, null);

        $this->assertEquals($new_id, $board->getGameId());
    }

    public function testLoadBoard()
    {

        $existing_id = uniqid();

        $this->repo->expects($this->once())
            ->method('loadBoard')
            ->with($existing_id);

        $board = new Board($this->repo, $existing_id);

        $this->assertEquals($existing_id, $board->getGameId());
    }

    public function testBoardRules()
    {

        //get the testing board and try moves with putDisc, playersTurn and not implemented features like how wins, invalid boards


    }

    protected function getTestBoard()
    {
        return array(
            array(0, 1, 0, 0, 1, 2, 0),
            array(0, 0, 0, 0, 1, 1, 0),
            array(0, 0, 0, 0, 1, 2, 0),
            array(0, 0, 0, 0, 1, 1, 0),
            array(0, 0, 0, 0, 0, 0, 0),



        );

    }
//
//
//    protected function isIdInvalid($param, $expected)
//    {
//        $result = $this->service->get($param);
//        $this->assertEquals($expected, isset($result['error']) && $result['error'] == 'validation');
//    }
//
//
//    public function testGetNotFound()
//    {
//        $this->ds->expects($this->once())
//            ->method('get')
//            ->with( $this->equalTo(23))
//            ->willReturn(array());
//
//        $result = $this->service->get(23);
//
//        $this->assertEquals(true, isset($result['error']) && $result['error'] == 'not_found');
//
//    }
//
//    public function testGetFound()
//    {
//        $db_mock = array('1');
//        $this->ds->expects($this->once())
//            ->method('get')
//            ->with( $this->equalTo(23))
//            ->willReturn($db_mock);
//
//        $result = $this->service->get(23);
//
//        $this->assertEquals(true, !isset($result['error']) );
//        $this->assertEquals($result, array('product' => $db_mock) );
//    }
//
//
//
//    public function testGetList()
//    {
//        $db_mock = array('1');
//        $this->ds->expects($this->once())
//            ->method('getList')
//            ->willReturn($db_mock);
//
//        $result = $this->service->getList();
//
//        $this->assertEquals(true, !isset($result['error']) );
//        $this->assertEquals($result, array('products' => $db_mock) );
//    }

//    public function testNoAutorizado()
//    {
//        $env = \Slim\Environment::mock(array(
//            'REQUEST_METHOD' => 'POST',
//            'slim.input' => 'authorized=no'
//        ));
//        $req = new RequestAdapter($env);
//
//        $autorizador = $this->getInstance();
//
//        $autorizado = $autorizador->requerirAutorizacion($req);
//
//        $this->assertEquals(false, $autorizado);
//    }


}
 