<?php

interface interfaceTeste
{
	public function adicao($p1, $p2);
	public function subtracao($p1, $p2);
}

class minhaClasse implements interfaceTeste
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

$eu = new minhaClasse();
echo $eu->adicao(100, 200);
echo '</br>';
echo $eu->subtracao(1000,500);


echo '</br></br>Fim do script.';
?>