<?php

abstract class classeBase
{
	abstract protected function adicao($p1, $p2);
	abstract protected function subtracao($p1, $p2);

	public function Apresentacao()
	{
		echo 'Esta é a apresentacao da função da classe base.';
	}
}

class primeira extends classeBase
{
	public function adicao($p1, $p2)
	{
		return $p1 + $p2;
	}

	public function subtracao($p1, $p2)
	{
		return $p1 - $p2;
	}
}


$eu = new primeira();
$eu->Apresentacao();
echo $eu->adicao(100,200);
echo '</br>';
echo $eu->subtracao(1000,500);

echo '</br></br>Fim do script.';
?>