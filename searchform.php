<?php 
$label=kpll__("Entrez votre recherche");
$placeholder=$submit=kpll__("Rechercher");
$action="";

if(KPLL) {
	$action=pll_current_language();
}

printf('<form role="search" method="get" class="search-form" action="/%s" >
			<label>
				<span class="screen-reader-text">%s</span>
				<input class="search-field" 
				placeholder="%s" value="" name="s" type="search"></label>
			<input class="search-submit" value="%s" type="submit">
		</form>',
		$action,
		$label,
		$placeholder,
		$submit
);