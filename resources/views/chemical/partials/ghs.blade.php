{{--  Placeholder for Hazard symbols descritions
      TODO: Clean it up and move somewhere else  --}}
<td>
  <b>{{ $item }}</b><br/>
  <b>{{ str_replace($item.' - ', '', trans('msds.h_symbols.'.$item)) }}</b>
</td>
<td>
  {!! Html::image('images/ghs/'.$item.'.gif', $item, ['title' => $item, 'height' => '100', 'width' => '100']) !!}
</td>
<td>
  @if($item == 'GHS01')
    <ul>
      <li>Unstable explosives</li>
      <li>Explosives of Divisions 1.1, 1.2, 1.3, 1.4</li>
      <li>Self reactive substances and mixtures, Types A,B</li>
      <li>Organic peroxides, Types A,B</li>
    </ul>
  @elseif($item == 'GHS02')
    <ul>
      <li>Flammable gases, category 1</li>
      <li>Flammable aerosols, categories 1,2</li>
      <li>Flammable liquids, categories 1,2,3</li>
      <li>Flammable solids, categories 1,2</li>
      <li>Self-reactive substances and mixtures, Types B,C,D,E,F</li>
      <li>Pyrophoric liquids, category 1</li>
      <li>Pyrophoric solids, category 1</li>
      <li>Self-heating substances and mixtures, categories 1,2</li>
      <li>Substances and mixtures, which in contact with water,</li>
      <li>emit flammable gases, categories 1,2,3</li>
      <li>Organic peroxides, Types B,C,D,E,F</li>
    </ul>
  @elseif($item == 'GHS03')
    <ul>
      <li>Oxidizing gases, category 1</li>
      <li>Oxidizing liquids, categories 1,2,3</li>
    </ul>
  @elseif($item == 'GHS04')
    <ul>
      <li>Gases under pressure</li>
      <ul>
        <li>Compressed gases</li>
        <li>Liquefied gases</li>
        <li>Refrigerated liquefied gases</li>
        <li>Dissolved gases</li>
      </ul>
    </ul>
  @elseif($item == 'GHS05')
    <ul>
      <li>Corrosive to metals, category 1</li>
      <li>Skin corrosion, categories 1A,1B,1C</li>
      <li>Serious eye damage, category 1</li>
    </ul>
  @elseif($item == 'GHS06')
    <ul>
      <li>Acute toxicity (oral, dermal, inhalation), categories 1,2,3</li>
    </ul>
  @elseif($item == 'GHS07')
    <ul>
      <li>Acute toxicity (oral, dermal, inhalation), category 4</li>
      <li>Skin irritation, category 2</li>
      <li>Eye irritation, category 2</li>
      <li>Skin sensitisation, category 1</li>
      <li>Specific Target Organ Toxicity – Single exposure, category 3</li>
    </ul>
  @elseif($item == 'GHS08')
    <ul>
      <li>Respiratory sensitization, category 1</li>
      <li>Germ cell mutagenicity, categories 1A,1B,2</li>
      <li>Carcinogenicity, categories 1A,1B,2</li>
      <li>Reproductive toxicity, categories 1A,1B,2</li>
      <li>Specific Target Organ Toxicity – Single exposure, categories 1,2</li>
      <li>Specific Target Organ Toxicity – Repeated exposure, categories 1,2</li>
      <li>Aspiration Hazard, category 1</li>
    </ul>
  @else
    <ul>
      <li>Hazardous to the aquatic environment</li>
      <ul>
        <li>Acute hazard, category1</li>
        <li>Chronic hazard, categories 1,2</li>
      </ul>
    </ul>
  @endif
</td>
