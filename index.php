
<?

abstract class Robot {
	protected $speed;
	protected $height;
	protected $weight;

	abstract public function getSpeed();

	abstract public function setSpeed( $speed );

	abstract public function getHeight();

	abstract public function setHeight( $height );

	abstract public function getWeight();

	abstract public function setWeight( $weight );
}

class Robot1 extends Robot {
	// Перший тип робота
	protected $speed = 1;
	protected $height = 10;
	protected $weight = 10;

	public function getSpeed() {
		return $this->speed;
	}

	public function setSpeed( $speed ) {
		$this->speed = $speed;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight( $height ) {
		$this->height = $height;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function setWeight( $weight ) {
		$this->weight = $weight;
	}
}

class Robot2 extends Robot {
	// Другій тип робота
	protected $speed = 2;
	protected $height = 20;
	protected $weight = 20;

	public function getSpeed() {
		return $this->speed;
	}

	public function setSpeed( $speed ) {
		$this->speed = $speed;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight( $height ) {
		$this->height = $height;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function setWeight( $weight ) {
		$this->weight = $weight;
	}
}

class MergeRobot extends Robot {
	// клас для об'єднання роботів
	protected $speed;
	protected $height;
	protected $weight;

	public function __construct() {
		$this->speed = null;
		$this->height = 0;
		$this->weight = 0;
	}

	public function addRobot( $robots ) {
		/* Даний клас поєднує в собі роботі
		 * Тобто взяли пусту оболочкку і додаєм віповідні характеристики до неї
		 * Тому за раз можна передати масив роботів
		 */
		if ( is_array( $robots ) ) {
			/* Перевіряємо чи передана декілька роботв для обєднання */
			foreach ( $robots as $robot ) {
				if ( $this->speed > $robot->getSpeed() OR is_null( $this->speed ) ) {
					$this->speed = $robot->getSpeed();
				}

				$this->height += $robot->getHeight();
				$this->weight += $robot->getWeight();
			}
		} else {
			if ( $this->speed > $robots->getSpeed() OR is_null( $this->speed ) ) {
				$this->speed = $robots->getSpeed();
			}
			$this->height += $robots->getHeight();
			$this->weight += $robots->getWeight();
		}
	}

	public function getSpeed() {
		return $this->speed;
	}

	public function setSpeed( $speed ) {
		$this->speed = $speed;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight( $height ) {
		$this->height = $height;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function setWeight( $weight ) {
		$this->weight = $weight;
	}
}

class FactoryRobot {
	private $cloneRobot1;
	private $cloneRobot2;
	private $cloneMergeRobot;
	private $arAllRobots = [];

	public function __construct() {
		$this->cloneRobot1 = new Robot1();
		$this->cloneRobot2 = new Robot2();
		$this->cloneMergeRobot = new MergeRobot();
	}

	public function addType( $robotParam ) {
		switch ( get_class( $robotParam ) ) {
			/* Перерисвоюємо параметри для клонування роботів */
			case 'Robot1':
				$this->cloneRobot1->setSpeed( $robotParam->getSpeed() );
				$this->cloneRobot1->setHeight( $robotParam->getHeight() );
				$this->cloneRobot1->setWeight( $robotParam->getWeight() );
				break;
			case 'Robot2':
				$this->cloneRobot2->setSpeed( $robotParam->getSpeed() );
				$this->cloneRobot2->setHeight( $robotParam->getHeight() );
				$this->cloneRobot2->setWeight( $robotParam->getWeight() );
				break;
			case 'MergeRobot':
				$this->cloneMergeRobot->setSpeed( $robotParam->getSpeed() );
				$this->cloneMergeRobot->setHeight( $robotParam->getHeight() );
				$this->cloneMergeRobot->setWeight( $robotParam->getWeight() );
				break;
		}

		return $robotParam;
	}

	public function getListRobots() {
		return $this->arAllRobots;
	}

	private function createNewRobots( $countRobots, $robotType ) {
		/* Клонування роботів */
		$arrayRobot = [];
		for ( $i = 0; $i < $countRobots; $i++ ) {
			$arrayRobot[ $i ] = clone $robotType;
		}

		/* Повертаємо створених роботів а решту зберігаємо */
		$this->arAllRobots = array_merge( $this->arAllRobots, $arrayRobot );

		return $arrayRobot;
	}

	public function createRobot1( $countRobots ) {
		return $this->createNewRobots( $countRobots, $this->cloneRobot1 );
	}

	public function createRobot2( $countRobots ) {
		return $this->createNewRobots( $countRobots, $this->cloneRobot2 );
	}

	public function createMergeRobot( $countRobots ) {
		return $this->createNewRobots( $countRobots, $this->cloneMergeRobot );
	}

	public function getSpeed() {
		$speed = $this->arAllRobots[ 0 ]->getSpeed();
		foreach ( $this->arAllRobots as $robot ) {
			if ( $speed > $robot->getSpeed() ) {
				$speed = $robot->getSpeed();
			}
		}

		return $speed;
	}

	public function getHeight() {
		$height = 0;
		foreach ( $this->arAllRobots as $robot ) {
			$height += $robot->getHeight();
		}

		return $height;
	}

	public function getWeight() {
		$weight = 0;
		foreach ( $this->arAllRobots as $robot ) {
			$weight += $robot->getWeight();
		}

		return $weight;
	}
}

echo '<pre>';
$factory = new FactoryRobot();
// Robot1, Robot2 типи роботів які може створювати фабрика
$factory->addType( new Robot1() );
$factory->addType( new Robot2() );
/**
 * Результатом роботи метода createRobot1 буде масив з 5 об’єктів класу Robot1
 * Результатом роботи метода createRobot2 буде масив з 2 об’єктів класу Robot2
 */
var_dump( $factory->createRobot1( 5 ) );
var_dump( $factory->createRobot2( 2 ) );
$mergeRobot = new MergeRobot();
$mergeRobot->addRobot( new Robot1() );
$mergeRobot->addRobot( $factory->createRobot2( 2 ) );
$factory->addType( $mergeRobot );
$res = reset( $factory->createMergeRobot( 1 ) );
//Результатом роботи методу буде мінімальна швидкість з усіх об’єднаних роботів
echo $res->getSpeed();
echo '<br>';
// Результатом роботи методу буде сума всіх ваг об’єднаних роботів
echo $res->getWeight();
