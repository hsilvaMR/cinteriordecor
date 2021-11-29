<div class="menuLateral">
    <div id="menuSlide" class="DN1024">
        <h3 class="menuTlm"><span class="menuIcon lnr lnr-menu"></span>MENU</h3>
    </div>
    <div id="acordiao" class="DB1024">
        <ul>
            <li>
                <a href="/admin/painel"><h3 class="<? if($sep==1){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-home"></span>Painel</h3>
                </a>
            </li>
            <li>
                <a href="/admin/homepages"><h3 class="<? if($sep==2){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-screen"></span>Homepage</h3>
                </a>
            </li>
            <!--
            <li>
                <h3 class="<? if($sep==2){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-screen"></span>Homepage<span class="menuSeta lnr lnr-chevron-<? if($sep==2){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=2){echo "none";}?>">
                    <li><a href="/admin/homepages" class="<? if($sub==2.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Todas as homepages</a></li>
                    <li><a href="/admin/homepage" class="<? if($sub==2.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova homepage</a></li>
                </ul>
            </li>
            -->
            <li>
                <a href="/admin/clientes"><h3 class="<? if($sep==16){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-users"></span>Clientes</h3>
                </a>
            </li>
            <li>
                <a href="/admin/essencias"><h3 class="<? if($sep==6){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-leaf"></span>Essência</h3>
                </a>
            </li>
            <!--
            <li>
                <h3 class="<? if($sep==6){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-leaf"></span>Essência<span class="menuSeta lnr lnr-chevron-<? if($sep==6){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=6){echo "none";}?>">
                    <li><a href="/admin/essencias" class="<? if($sub==6.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Todas as essencias</a></li>
                    <li><a href="/admin/essencia" class="<? if($sub==6.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova essencia</a></li>
                </ul>
            </li>
            -->
            <li>
                <h3 class="<? if($sep==3){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-apartment"></span>Projectos<span class="menuSeta lnr lnr-chevron-<? if($sep==3){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=3){echo "none";}?>">
                    <li><a href="/admin/projectos" class="<? if($sub==3.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Projectos</a></li>
                    <li><a href="/admin/ordenar_projectos" class="<? if($sub==3.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Ordenar</a></li>
                </ul>
            </li>
            <!--
            <li>
                <h3 class="<? if($sep==3){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-apartment"></span>Projecto<span class="menuSeta lnr lnr-chevron-<? if($sep==3){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=3){echo "none";}?>">
                    <li><a href="/admin/projectos" class="<? if($sub==3.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Todos os projectos</a></li>
                    <li><a href="/admin/projecto" class="<? if($sub==3.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Novo projecto</a></li>
                </ul>
            </li>
            -->
            <li>
                <h3 class="<? if($sep==4){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-diamond"></span>Produtos<span class="menuSeta lnr lnr-chevron-<? if($sep==4){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=4){echo "none";}?>">
                    <li><a href="/admin/produtos" class="<? if($sub==4.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Produtos</a></li>
                    <!--<li><a href="/admin/produto" class="<? if($sub==4.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Novo produto</a></li>-->
                    <li><a href="/admin/categorias" class="<? if($sub==4.3){echo "menuSubSelec";}else{echo "menuSub";}?>">Categorias</a></li>
                    <!--<li><a href="/admin/categoria" class="<? if($sub==4.4){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova categoria</a></li>-->
                    <li><a href="/admin/ordenar_categoria" class="<? if($sub==4.5){echo "menuSubSelec";}else{echo "menuSub";}?>">Ordenar</a></li>
                </ul>
            </li>
            <li>
                <a href="/admin/noticias"><h3 class="<? if($sep==5){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-book"></span>Notícias</h3>
                </a>
            </li>
            <!--
            <li>
                <h3 class="<? if($sep==5){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-book"></span>Notícias<span class="menuSeta lnr lnr-chevron-<? if($sep==5){echo "down";}else{echo "right";}?>"></span>
                </h3>
                <ul  class="<? if($sep!=5){echo "none";}?>">
                    <li><a href="/admin/noticias" class="<? if($sub==5.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Todas as notícias</a></li>
                    <li><a href="/admin/noticia" class="<? if($sub==5.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova notícia</a></li>
                </ul>
            </li>
            -->
            <li>
                <a href="/admin/banners">
                <h3 class="<? if($sep==10){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-flag"></span>Banners
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/promocoes">
                <h3 class="<? if($sep==11){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-thumbs-up"></span>Promoções
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/vales">
                <h3 class="<? if($sep==17){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-tag"></span>Vales de Desconto
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/portes">
                <h3 class="<? if($sep==12){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-gift"></span>Portes
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/vendas">
                <h3 class="<? if($sep==8){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-cart"></span>Vendas
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/avaliacoes">
                <h3 class="<? if($sep==15){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-smile"></span>Avaliações
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/contactos">
                <h3 class="<? if($sep==7){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-phone"></span>Contactos
                </h3>
                </a>
            </li>
            <li>
                <a href="/admin/sorteios"><h3 class="<? if($sep==14){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-bullhorn"></span>Sorteio</h3>
                </a>
            </li>
            <li>
                <a href="/admin/newsletters"><h3 class="<? if($sep==13){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-rocket"></span>Newsletters</h3>
                </a>
            </li>
            <li>
                <a href="/admin/password"><h3 class="<? if($sep==9){echo "menuSelec";}else{echo "menuSeparador";}?>">
                    <span class="menuIcon lnr lnr-lock"></span>Password</h3>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#acordiao h3").click(function(){
        $("#acordiao ul ul").slideUp();
        if(!$(this).next().is(":visible"))
        {
            $(this).next().slideDown();
        }
    })
    $("#menuSlide h3").click(function(){
        $("#acordiao").slideToggle();
    })
})
</script>