<?php

class defaultController
{
	private $_f3; // Router

    /**
     * @var
     */
    private $_val;


	public function __construct($f3)
	{
		$this->_f3 = $f3;

	}

	public function home()
	{
		$view = new Template();
		echo $view->render("views/home.html");
	}

	public function form1()
	{
        $_SESSION['animal']->$_POST['animal'];

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$animal = $_POST['animal'];

			if (validString($animal)) {
				$_SESSION['animal'] = $animal;
				switch (strtolower($animal)) {
					case "dog":
						$pet = new Dog();
						break;
					case "cat":
						$pet = new Cat();
						break;
					case "snake":
						$pet = new Snake();
						break;
					default:
						$pet = new Pet();
				}
				$_SESSION['pet'] = $pet;
				$this->_f3->reroute('/order2');
			} else {
				$this->_f3->set("errors['animal']", "Please enter an animal.");
			}
		}
		$view = new Template();
		echo $view->render("views/form1.html");
	}

	public function form2()
	{
        $_SESSION['name']->$_POST['name'];
        $_SESSION['color'] = "Select a color";

		if ($_SERVER['REQUEST_METHOD'] == "POST"){
		    $name = $_POST['name'];
		    $color = $_POST['color'];
		    $valid = 0;

		    if ($color != $_SESSION['color']) {
                $_SESSION['pet']->setColor($color);
                $valid++;
            }
		    if (validString($name)) {
                $_SESSION['pet']->setName($name);
                $valid++;
            }
		    if ($valid == 2) {
                $this->_f3->reroute('/results');
            }
		}

		$view = new Template();
		echo $view->render("views/form2.html");
	}

	public function form3()
	{
	    $GLOBALS['db']->addPets($_SESSION['pet'].getName(), $_SESSION['pet'].getColor(), $_SESSION['pet'].getType());
		$view = new Template();
		echo $view->render("views/results.html");
	}

    public function show()
    {
        $pets = $GLOBALS['db']->allPets();
        $this->_f3->set('Pets', $pets);

        $template = new Template();
        echo $template->render('views/views.html');
    }
}