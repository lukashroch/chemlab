@extends('app')

@section('title-content')
  {{ trans('common.homepage') }}
@endsection

@section('content')
  @component('partials.nav')
    <li class="breadcrumb-item">{{ trans('common.homepage') }}</li>
  @endcomponent

  <div id="accordion" role="tablist" aria-multiselectable="true">
    <div class="card mb-2">
      <div class="card-header" role="tab" id="chemical-insert-heading">
        <h6 class="card-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#chemical-insert" aria-expanded="true"
             aria-controls="chemical-insert">
            <span class="fa fa-chevron-down" aria-hidden="true"></span> Vkládání chemikálií do
            systému - základní informace
          </a>
        </h6>
      </div>
      <div id="chemical-insert" class="collapse show" role="tabpanel" aria-labelledby="chemical-insert-heading">
        <div class="card-block">
          <p>Vložení nové chemikálie do systému probíhá přes nabídku <strong>možnosti</strong>
            v {{ link_to_route('chemical.index', 'seznamu chemikálií') }}.</p>
          <p>Jediný údaj nutný k vyplnění je <strong>název chemikálie</strong>. Ostatní informace jsou
            volitelné.
          <p>Je doporučeno ale vyplnit co nejvíce informací o dané položce. Čím více informací bude vyplněno,
            tím snáze bude chemikálie v systému vyhledatelná.
            {{ link_to_route('chemical.index', 'Vyhledávání') }} umožňuje procházet databázi
            podle různých identifikátorů, a pokud nejsou vyplněny, chemikálie nebude logicky nalezena.</p>
          <p>Při vyplňování identifikačních údajů výrobce je vhodné dát pozor, jestli daná chemikálie už není
            v systému přítomna.
            Pokud je vyplněna již existující dvojice údajů (výrobce + ID chemikálie), která již v systému
            existuje, systém nabídne možnost přejít na tuto existující chemikálii.
            Je vhodné tento odkaz následovat a tím zamezit tvorbě zbytečných duplikátů v databázi.</p>
          <p>V současné době v databázi existují duplikáty - chemikálie stejné kvality (stejného výrobce). Ty
            budou postupně sjednoceny a pak už nebude možné vytvořit novou chemikálii od stejného
            výrobce.</p>
          <p>Po uložení hlavičky se základními informacemi o chemikálií dojde ke zpřístupnění možnosti vložení
            položek do jednotlivých skladů.</p>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" role="tab" id="chemical-data-heading">
        <h6 class="card-title">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#chemical-data"
             aria-expanded="false" aria-controls="chemical-data">
            <span class="fa fa-chevron-down" aria-hidden="true"></span> Vkládání chemikálií do
            systému - stahování dat o chemikáliích
          </a>
        </h6>
      </div>
      <div id="chemical-data" class="collapse" role="tabpanel" aria-labelledby="chemical-data-heading">
        <div class="card-block">
          <p>Při vkládání nebo úpravě chemikálií do systému jsou k dispozici v základu dvě metody nebo
            kombinace obou metod, které usnadní vložení co nejvíce informací o chemikálii.
            Tyto metody jsou přístupné přes menu ve formuláři chemikálie.</p>
          <p><strong>První možnost</strong> využívá
            služby {{ link_to('http://cactus.nci.nih.gov/chemical/structure', 'Cactus NCI (Chemical Identifier Resolver)', array('target' => '_blank')) }}
            .
            <strong>Tuto metodu doporučuji dělat u všech vkládaných chemikálií.</strong><br/>
            Pro získání dat z Cactus NCI je nutné vložit alespoň jeden z těchto dvou identifikátorů:
          <ul>
            <li>CAS identifikátor</li>
            <li>Název chemikálie (standardizovaná podoba)</li>
          </ul>
          Název chemikálie nemusí to být nutně hned IUPAC, Cactus NCI si poradí i s různými generickými či
          triviálními názvy.
          Pokud vložíte CAS identifikátor, systém upřednostní tento identifikátor, protože je více "unikátní"
          a má vyšší procento na vrácení úspěšného výsledku.<br/>
          Tímto způsobem je možné stáhnout všechna nabízená data najednou nebo podle potřeby jednotlivě.</p>
          <p><strong>Druhou metodou</strong> je stažení informací ze Sigma Aldrich webu. Tato metoda je vázáná
            na chemikálie zakoupené u Sigma Aldrich (resp. na Sigma Aldrich ID).<br/>
            Pro získání dat ze Sigma Aldrich je tady nutné vložit do formuláře toto ID. Sigma Aldrich
            distribuuje chemikálie pod různými značkami (Sigma, Sial, Aldrich, Fluka...). Správnou značku
            není třeba vybírat, pokud systém najde chemikálii podle ID, značku si doplní sám.<br/>
            Množství získaných dat je pak odvislé na množství dat přístupných na Sigma Aldrich webu.
          </p>
          <p><strong>Třetí metoda kombinuje první dvě metody.</strong> Předpoklad je opět mít chemikálii od
            Sigma Aldrich (resp. mít Sigma Aldrich ID).<br/>
            Systém se nejdříve pokusí podle Sigma Aldrich ID stáhnout data přístupná na Sigma Aldrich webu.
            Pokud se podařilo stáhnout validní CAS nebo název chemikálie, zbytek informací se postahuje z
            Cactus NCI.</p>
        </div>
      </div>
    </div>
  </div>
@endsection
