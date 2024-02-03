<?php

return [
    'title' => 'Safety information',
    'sds' => [
        '_' => 'Safety Data Sheet',
        'download' => 'Download',
        'not-found' => 'No SDS file upload yet.',
        'vendor' => 'Vendor\'s website',
    ],
    'symbol' => 'Pictogram',
    'signal_word' => 'Signal word',
    'h_title' => 'Hazard statements',
    'h_abbr' => 'H-statements',
    'p_title' => 'Precautionary statements',
    'p_abbr' => 'P-statements',
    'r_title' => 'Risk phrases',
    'r_abbr' => 'R-phrases',
    's_title' => 'Safety phrases',
    's_abbr' => 'S-phrases',

    'symbols' => [
        'GHS01' => 'GHS01 - Exploding bomb',
        'GHS02' => 'GHS02 - Flame',
        'GHS03' => 'GHS03 - Flame over circle',
        'GHS04' => 'GHS04 - Gas cylinder',
        'GHS05' => 'GHS05 - Corrosion',
        'GHS06' => 'GHS06 - Skull and crossbones',
        'GHS07' => 'GHS07 - Exclamation mark',
        'GHS08' => 'GHS08 - Health hazard',
        'GHS09' => 'GHS09 - Environment',
    ],

    'h' => [
        'H200' => 'H200 - Unstable explosives.',
        'H201' => 'H201 - Explosive, mass explosion hazard.',
        'H202' => 'H202 - Explosive, severe projection hazard.',
        'H203' => 'H203 - Explosive, fire, blast or projection hazard.',
        'H204' => 'H204 - Fire or projection hazard.',
        'H205' => 'H205 - May mass explode in fire.',
        'H220' => 'H220 - Extremely flammable gas.',
        'H221' => 'H221 - Flammable gas.',
        'H222' => 'H222 - Extremely flammable aerosol.',
        'H223' => 'H223 - Flammable aerosol.',
        'H224' => 'H224 - Extremely flammable liquid and vapour.',
        'H225' => 'H225 - Highly flammable liquid and vapour.',
        'H226' => 'H226 - Flammable liquid and vapour.',
        'H228' => 'H228 - Flammable solid.',
        'H240' => 'H240 - Heating may cause an explosion.',
        'H241' => 'H241 - Heating may cause a fire or explosion.',
        'H242' => 'H242 - Heating may cause a fire.',
        'H250' => 'H250 - Catches fire spontaneously if exposed to air.',
        'H251' => 'H251 - Self-heating: may catch fire.',
        'H252' => 'H252 - Self-heating in large quantities; may catch fire.',
        'H260' => 'H260 - In contact with water releases flammable gases which may ignite spontaneously.',
        'H261' => 'H261 - In contact with water releases flammable gases.',
        'H270' => 'H270 - May cause or intensify fire; oxidiser.',
        'H271' => 'H271 - May cause fire or explosion; strong oxidiser.',
        'H272' => 'H272 - May intensify fire; oxidiser.',
        'H280' => 'H280 - Contains gas under pressure; may explode if heated.',
        'H281' => 'H281 - Contains refrigerated gas; may cause cryogenic burns or injury.',
        'H290' => 'H290 - May be corrosive to metals.',
        'H300' => 'H300 - Fatal if swallowed.',
        'H301' => 'H301 - Toxic if swallowed.',
        'H302' => 'H302 - Harmful if swallowed.',
        'H304' => 'H304 - May be fatal if swallowed and enters airways.',
        'H310' => 'H310 - Fatal in contact with skin.',
        'H311' => 'H311 - Toxic in contact with skin.',
        'H312' => 'H312 - Harmful in contact with skin.',
        'H314' => 'H314 - Causes severe skin burns and eye damage.',
        'H315' => 'H315 - Causes skin irritation.',
        'H317' => 'H317 - May cause an allergic skin reaction.',
        'H318' => 'H318 - Causes serious eye damage.',
        'H319' => 'H319 - Causes serious eye irritation.',
        'H330' => 'H330 - Fatal if inhaled.',
        'H331' => 'H331 - Toxic if inhaled.',
        'H332' => 'H332 - Harmful if inhaled.',
        'H334' => 'H334 - May cause allergy or asthma symptoms or breathing difficulties if inhaled.',
        'H335' => 'H335 - May cause respiratory irritation.',
        'H336' => 'H336 - May cause drowsiness or dizziness.',
        'H340' => 'H340 - May cause genetic defects, exposure cause the hazard.',
        'H341' => 'H341 - Suspected of causing genetic defects.',
        'H350' => 'H350 - May cause cancer.',
        'H351' => 'H351 - Suspected of causing cancer.',
        'H360' => 'H360 - May damage fertility or the unborn child.',
        'H361' => 'H361 - Suspected of damaging fertility or the unborn child.',
        'H362' => 'H362 - May cause harm to breast-fed children.',
        'H370' => 'H370 - Causes damage to organs.',
        'H371' => 'H371 - May cause damage to organs.',
        'H372' => 'H372 - Causes damage to organs through prolonged or repeated exposure exposure cause the hazard.',
        'H373' => 'H373 - May cause damage to organs through prolonged or repeated exposure exposure cause the hazard.',
        'H400' => 'H400 - Very toxic to aquatic life.',
        'H410' => 'H410 - Very toxic to aquatic life with long lasting effects.',
        'H411' => 'H411 - Toxic to aquatic life with long lasting effects.',
        'H412' => 'H412 - Harmful to aquatic life with long lasting effects.',
        'H413' => 'H413 - May cause long lasting harmful effects to aquatic life.',
        'H300+H310' => 'H300+H310 - Fatal if swallowed or in contact with skin.',
        'H300+H330' => 'H300+H330 - Fatal if swallowed or inhaled.',
        'H310+H330' => 'H310+H330 - Fatal if in contact with skin or inhaled.',
        'H300+H310+H330' => 'H300+H310+H330 - Fatal if swallowed, in contact with skin or inhaled.',
        'H301+H311' => 'H301+H311 - Toxic if swallowed or in contact with skin.',
        'H301+H331' => 'H301+H331 - Toxic if swallowed or inhaled.',
        'H311+H331' => 'H311+H331 - Toxic if in contact with skin or inhaled.',
        'H301+H311+H331' => 'H301+H311+H331 - Toxic if swallowed, in contact with skin or inhaled.',
        'H302+H312' => 'H302+H312 - Harmful if swallowed or in contact with skin.',
        'H302+H332' => 'H302+H332 - Harmful if swallowed or inhaled.',
        'H312+H332' => 'H312+H332 - Harmful if in contact with skin or inhaled.',
        'H302+H312+H332' => 'H302+H312+H332 - Harmful if swallowed, in contact with skin or inhaled.',

        'EUH001' => 'EUH001 – Explosive when dry.',
        'EUH006' => 'EUH006 – Explosive with or without contact with air.',
        'EUH014' => 'EUH014 – Reacts violently with water.',
        'EUH018' => 'EUH018 – In use, may form flammable/explosive vapour-air mixture.',
        'EUH019' => 'EUH019 – May form explosive peroxides.',
        'EUH044' => 'EUH044 – Risk of explosion if heated under confinement.',
        'EUH029' => 'EUH029 – Contact with water liberates toxic gas.',
        'EUH031' => 'EUH031 – Contact with acids liberates toxic gas.',
        'EUH032' => 'EUH032 – Contact with acids liberates very toxic gas.',
        'EUH066' => 'EUH066 – Repeated exposure may cause skin dryness or cracking.',
        'EUH070' => 'EUH070 – Toxic by eye contact.',
        'EUH071' => 'EUH071 – Corrosive to the respiratory tract.',
        'EUH059' => 'EUH059 – Hazardous to the ozone layer.',
        'EUH201' => 'EUH201 – Contains lead. Should not be used on surfaces liable to be chewed or sucked by children.',
        'EUH201A' => 'EUH201A – Warning! Contains lead.',
        'EUH202' => 'EUH202 – Cyanoacrylate. Danger. Bonds skin and eyes in seconds. Keep out of the reach of children.',
        'EUH203' => 'EUH203 – Contains chromium (VI). May produce an allergic reaction.',
        'EUH204' => 'EUH204 – Contains isocyanates. May produce an allergic reaction.',
        'EUH205' => 'EUH205 – Contains epoxy constituents. May produce an allergic reaction.',
        'EUH206' => 'EUH206 – Warning! Do not use together with other products. May release dangerous gases (chlorine)',
        'EUH207' => 'EUH207 – Warning! Contains cadmium. Dangerous fumes are formed during use. See information supplied by the manufacturer. Comply with the safety instructions.',
        'EUH208' => 'EUH208 – Contains (name of sensitising substance). May produce an allergic reaction.',
        'EUH209' => 'EUH209 – Can become highly flammable in use.',
        'EUH209A' => 'EUH209A – Can become flammable in use.',
        'EUH210' => 'EUH210 – Safety data sheet available on request.',
        'EUH401' => 'EUH401 – To avoid risks to human health and the environment, comply with the instructions for use.'
    ],

    'p' => [
        // Precautionary statements - General
        'P101' => 'P101 - If medical advice is needed, have product container or label at hand.',
        'P102' => 'P102 - Keep out of reach of children.',
        'P103' => 'P103 - Read label before use.',

        // Precautionary statements — Prevention
        'P201' => 'P201 - Obtain special instructions before use.',
        'P202' => 'P202 - Do not handle until all safety precautions have been read and understood.',
        'P210' => 'P210 - Keep away from heat/sparks/open flames/hot surfaces. — No smoking.',
        'P211' => 'P211 - Do not spray on an open flame or other ignition source.',
        'P220' => 'P220 - Keep/Store away from clothing/…/combustible materials.',
        'P221' => 'P221 - Take any precaution to avoid mixing with combustibles…',
        'P222' => 'P222 - Do not allow contact with air.',
        'P223' => 'P223 - Keep away from any possible contact with water, because of violent reaction and possible flash fire.',
        'P230' => 'P230 - Keep wetted with…',
        'P231' => 'P231 - Handle under inert gas.',
        'P232' => 'P232 - Protect from moisture.',
        'P233' => 'P233 - Keep container tightly closed.',
        'P234' => 'P234 - Keep only in original container.',
        'P235' => 'P235 - Keep cool.',
        'P240' => 'P240 - Ground/bond container and receiving equipment.',
        'P241' => 'P241 - Use explosion-proof electrical/ventilating/lighting/…/equipment.',
        'P242' => 'P242 - Use only non-sparking tools.',
        'P243' => 'P243 - Take precautionary measures against static discharge.',
        'P244' => 'P244 - Keep reduction valves free from grease and oil.',
        'P250' => 'P250 - Do not subject to grinding/shock/…/friction.',
        'P251' => 'P251 - Pressurized container: Do not pierce or burn, even after use.',
        'P260' => 'P260 - Do not breathe dust/fume/gas/mist/vapours/spray.',
        'P261' => 'P261 - Avoid breathing dust/fume/gas/mist/vapours/spray.',
        'P262' => 'P262 - Do not get in eyes, on skin, or on clothing.',
        'P263' => 'P263 - Avoid contact during pregnancy/while nursing.',
        'P264' => 'P264 - Wash … thoroughly after handling.',
        'P270' => 'P270 - Do no eat, drink or smoke when using this product.',
        'P271' => 'P271 - Use only outdoors or in a well-ventilated area.',
        'P272' => 'P272 - Contaminated work clothing should not be allowed out of the workplace.',
        'P273' => 'P273 - Avoid release to the environment.',
        'P280' => 'P280 - Wear protective gloves/protective clothing/eye protection/face protection.',
        'P281' => 'P281 - Use personal protective equipment as required.',
        'P282' => 'P282 - Wear cold insulating gloves/face shield/eye protection.',
        'P283' => 'P283 - Wear fire/flame resistant/retardant clothing.',
        'P284' => 'P284 - Wear respiratory protection.',
        'P285' => 'P285 - In case of inadequate ventilation wear respiratory protection.',
        'P231+P232' => '231+232 - Handle under inert gas. Protect from moisture.',
        'P235+P410' => 'P235+P410 - Keep cool. Protect from sunlight.',

        // Precautionary statements — Response
        'P301' => 'P301 - IF SWALLOWED:',
        'P302' => 'P302 - IF ON SKIN:',
        'P303' => 'P303 - IF ON SKIN (or hair):',
        'P304' => 'P304 - IF INHALED:',
        'P305' => 'P305 - IF IN EYES:',
        'P306' => 'P306 - IF ON CLOTHING:',
        'P307' => 'P307 - IF exposed:',
        'P308' => 'P308 - IF exposed or concerned:',
        'P309' => 'P309 - IF exposed or if you feel unwell:',
        'P310' => 'P310 - Immediately call a POISON CENTER or doctor/physician.',
        'P311' => 'P311 - Call a POISON CENTER or doctor/physician.',
        'P312' => 'P312 - Call a POISON CENTER or doctor/physician if you feel unwell.',
        'P313' => 'P313 - Get medical advice/attention.',
        'P314' => 'P314 - Get medical advice/attention if you feel unwell.',
        'P315' => 'P315 - Get immediate medical advice/attention.',
        'P320' => 'P320 - Specific treatment is urgent (see … on this label).',
        'P321' => 'P321 - Specific treatment (see … on this label).',
        'P322' => 'P322 - Specific measures (see … on this label).',
        'P330' => 'P330 - Rinse mouth.',
        'P331' => 'P331 - Do NOT induce vomiting.',
        'P332' => 'P332 - If skin irritation occurs:',
        'P333' => 'P333 - If skin irritation or rash occurs:',
        'P334' => 'P334 - Immerse in cool water/wrap in wet bandages.',
        'P335' => 'P335 - Brush off loose particles from skin.',
        'P336' => 'P336 - Thaw frosted parts with lukewarm water. Do no rub affected area.',
        'P337' => 'P337 - If eye irritation persists:',
        'P338' => 'P338 - Remove contact lenses, if present and easy to do. Continue rinsing.',
        'P340' => 'P340 - Remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P341' => 'P341 - If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P342' => 'P342 - If experiencing respiratory symptoms:',
        'P350' => 'P350 - Gently wash with plenty of soap and water.',
        'P351' => 'P351 - Rinse cautiously with water for several minutes.',
        'P352' => 'P352 - Wash with plenty of soap and water.',
        'P353' => 'P353 - Rinse skin with water/shower.',
        'P360' => 'P360 - Rinse immediately contaminated clothing and skin with plenty of water before removing clothes.',
        'P361' => 'P361 - Remove/Take off immediately all contaminated clothing.',
        'P362' => 'P362 - Take off contaminated clothing and wash before reuse.',
        'P363' => 'P363 - Wash contaminated clothing before reuse.',
        'P370' => 'P370 - In case of fire:',
        'P371' => 'P371 - In case of major fire and large quantities:',
        'P372' => 'P372 - Explosion risk in case of fire.',
        'P373' => 'P373 - DO NOT fight fire when fire reaches explosives.',
        'P374' => 'P374 - Fight fire with normal precautions from a reasonable distance.',
        'P375' => 'P375 - Fight fire remotely due to the risk of explosion.',
        'P376' => 'P376 - Stop leak if safe to do so.',
        'P377' => 'P377 - Leaking gas fire: Do not extinguish, unless leak can be stopped safely.',
        'P378' => 'P378 - Use … for extinction.',
        'P380' => 'P380 - Evacuate area.',
        'P381' => 'P381 - Eliminate all ignition sources if safe to do so.',
        'P390' => 'P390 - Absorb spillage to prevent material damage.',
        'P391' => 'P391 - Collect spillage.',
        'P301+P310' => 'P301+P310 - IF SWALLOWED: Immediately call a POISON CENTER or doctor/physician.',
        'P301+P312' => 'P301+P312 - IF SWALLOWED: Call a POISON CENTER or doctor/physician if you feel unwell.',
        'P301+P330+P331' => 'P301+P330+P331 - IF SWALLOWED: rinse mouth. Do NOT induce vomiting.',
        'P302+P334' => 'P302+P334 - IF ON SKIN: Immerse in cool water/wrap in wet bandages.',
        'P302+P350' => 'P302+P350 - IF ON SKIN: Gently wash with plenty of soap and water.',
        'P302+P352' => 'P302+P353 - IF ON SKIN: Wash with plenty of soap and water.',
        'P303+P361+P353' => 'P303+P361+P353 - IF ON SKIN (or hair): Remove/Take off immediately all contaminated clothing. Rinse skin with water/shower.',
        'P304+P340' => 'P304+P340 - IF INHALED: Remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P304+P341' => 'P304+P341 - IF INHALED: If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P305+P351+P338' => 'P305+P351+P338 - IF IN EYES: Rinse cautiously with water for several minutes. Remove contact lenses, if present and easy to do. Continue rinsing.',
        'P306+P360' => 'P306+P360 - IF ON CLOTHING: rinse immediately contaminated clothing and skin with plenty of water before removing clothes.',
        'P307+P311' => 'P307+P311 - IF exposed: Call a POISON CENTER or doctor/physician.',
        'P308+P313' => 'P308+P313 - IF exposed or concerned: Get medical advice/attention.',
        'P309+P311' => 'P309+P311 - IF exposed or if you feel unwell: Call a POISON CENTER or doctor/physician.',
        'P332+P313' => 'P332+P313 - If skin irritation occurs: Get medical advice/attention.',
        'P333+P313' => 'P333+P313 - If skin irritation or rash occurs: Get medical advice/attention.',
        'P335+P334' => 'P335+P334 - Brush off loose particles from skin. Immerse in cool water/wrap in wet bandages.',
        'P337+P313' => 'P337+P313 - If eye irritation persists: Get medical advice/attention.',
        'P342+P311' => 'P342+P311 - If experiencing respiratory symptoms: Call a POISON CENTER or doctor/physician.',
        'P370+P376' => 'P370+P376 - In case of fire: Stop leak if safe to do so.',
        'P370+P378' => 'P370+P378 - In case of fire: Use … for extinction.',
        'P370+P380' => 'P101 - In case of fire: Evacuate area.',
        'P370+P380+P375' => 'P370+P380+P375 - In case of fire: Evacuate area. Fight fire remotely due to the risk of explosion.',
        'P371+P380+P375' => 'P371+P380+P375 - In case of major fire and large quantities: Evacuate area. Fight fire remotely due to the risk of explosion.',

        // Precautionary statements — Storage
        'P401' => 'P401 - Store …',
        'P402' => 'P402 - Store in a dry place.',
        'P403' => 'P403 - Store in a well-ventilated place.',
        'P404' => 'P404 - Store in a closed container.',
        'P405' => 'P405 - Store locked up.',
        'P406' => 'P406 - Store in corrosive resistant/… container with a resistant inner liner.',
        'P407' => 'P407 - Maintain air gap between stacks/pallets.',
        'P410' => 'P410 - Protect from sunlight.',
        'P411' => 'P411 - Store at temperatures not exceeding … oC/…oF.',
        'P412' => 'P412 - Do not expose to temperatures exceeding 50 oC/122oF.',
        'P413' => 'P413 - Store bulk masses greater than … kg/… lbs at temperatures not exceeding … oC/…oF.',
        'P420' => 'P420 - Store away from other materials.',
        'P422' => 'P422 - Store contents under …',
        'P402+P404' => 'P402+P404 - Store in a dry place. Store in a closed container.',
        'P403+P233' => 'P403+P233 - Store in a well-ventilated place. Keep container tightly closed.',
        'P403+P235' => 'P403+P235 - Store in a well-ventilated place. Keep cool.',
        'P410+P403' => 'P410+P403 - Protect from sunlight. Store in a well-ventilated place.',
        'P410+P412' => 'P410+P412 - Protect from sunlight. Do no expose to temperatures exceeding 50 oC/122oF.',
        'P411+P235' => 'P411+P235 - Store at temperatures not exceeding … oC/…oF. Keep cool.',

        // Precautionary statements — Disposal
        'P501' => 'P501 - Dispose of contents/container to …',
        'P502' => 'P502 - Refer to manufacturer/supplier for information on recovery/recycling'
    ],

    'r' => [
        'R1' => 'R1 - Explosive when dry.',
        'R2' => 'R2 - Risk of explosion by shock, friction, fire or other sources of ignition.',
        'R3' => 'R3 - Extreme risk of explosion by shock, friction, fire or other sources of ignition.',
        'R4' => 'R4 - Forms very sensitive explosive metallic compounds.',
        'R5' => 'R5 - Heating may cause an explosion.',
        'R6' => 'R6 - Explosive with or without contact with air.',
        'R7' => 'R7 - May cause fire.',
        'R8' => 'R8 - Contact with combustible material may cause fire.',
        'R9' => 'R9 - Explosive when mixed with combustible material.',
        'R10' => 'R10 - Flammable.',
        'R11' => 'R11 - Highly flammable.',
        'R12' => 'R12 - Extremely flammable.',
        'R14' => 'R14 - Reacts violently with water.',
        'R15' => 'R15 - Contact with water liberates extremely flammable gases.',
        'R16' => 'R16 - Explosive when mixed with oxidizing substances.',
        'R17' => 'R17 - Spontaneously flammable in air.',
        'R18' => 'R18 - In use, may form flammable/explosive vapour-air mixture.',
        'R19' => 'R19 - May form explosive peroxides.',
        'R20' => 'R20 - Harmful by inhalation.',
        'R21' => 'R21 - Harmful in contact with skin.',
        'R22' => 'R22 - Harmful if swallowed.',
        'R23' => 'R23 - Toxic by inhalation.',
        'R24' => 'R24 - Toxic in contact with skin.',
        'R25' => 'R25 - Toxic if swallowed.',
        'R26' => 'R26 - Very toxic by inhalation.',
        'R27' => 'R27 - Very toxic in contact with skin.',
        'R28' => 'R28 - Very toxic if swallowed.',
        'R29' => 'R29 - Contact with water liberates toxic gas.',
        'R30' => 'R30 - Can become highly flammable in use.',
        'R31' => 'R31 - Contact with acids liberates toxic gas.',
        'R32' => 'R32 - Contact with acids liberates very toxic gas.',
        'R33' => 'R33 - Danger of cumulative effects.',
        'R34' => 'R34 - Causes burns.',
        'R35' => 'R35 - Causes severe burns.',
        'R36' => 'R36 - Irritating to eyes.',
        'R37' => 'R37 - Irritating to respiratory system.',
        'R38' => 'R38 - Irritating to skin.',
        'R39' => 'R39 - Danger of very serious irreversible effects.',
        'R40' => 'R40 - Limited evidence of a carcinogenic effect.',
        'R41' => 'R41 - Risk of serious damage to eyes.',
        'R42' => 'R42 - May cause sensitization by inhalation.',
        'R43' => 'R43 - May cause sensitisation by skin contact.',
        'R44' => 'R44 - Risk of explosion if heated under confinement.',
        'R45' => 'R45 - May cause cancer.',
        'R46' => 'R46 - May cause heritable genetic damage.',
        'R48' => 'R48 - Danger of serious damage to health by prolonged exposure.',
        'R49' => 'R49 - May cause cancer by inhalation.',
        'R50' => 'R50 - Very toxic to aquatic organisms.',
        'R51' => 'R51 - Toxic to aquatic organisms.',
        'R52' => 'R52 - Harmful to aquatic organisms.',
        'R53' => 'R53 - May cause long-term adverse effects in the aquatic environment.',
        'R54' => 'R54 - Toxic to flora.',
        'R55' => 'R55 - Toxic to fauna.',
        'R56' => 'R56 - Toxic to soil organisms.',
        'R57' => 'R57 - Toxic to bees.',
        'R58' => 'R58 - May cause long-term adverse effects in the environment.',
        'R59' => 'R59 - Dangerous for the ozone layer.',
        'R60' => 'R60 - May impair fertility.',
        'R61' => 'R61 - May cause harm to the unborn child.',
        'R62' => 'R62 - Possible risk of impaired fertility.',
        'R63' => 'R63 - Possible risk of harm to the unborn child.',
        'R64' => 'R64 - May cause harm to breastfed babies.',
        'R65' => 'R65 - Harmful: may cause lung damage if swallowed.',
        'R66' => 'R66 - Repeated exposure may cause skin dryness or cracking.',
        'R67' => 'R67 - Vapours may cause drowsiness and dizziness.',
        'R68' => 'R68 - Possible risk of irreversible effects.',
        'R14/15' => 'R14/15 - Reacts violently with water, liberating extremely flammable gases.',
        'R15/29' => 'R15/29 - Contact with water liberates toxic, extremely flammable gas.',
        'R20/21' => 'R20/21 - Harmful by inhalation and in contact with skin.',
        'R20/22' => 'R20/22 - Harmful by inhalation and if swallowed.',
        'R21/22' => 'R21/22 - Harmful in contact with skin and if swallowed.',
        'R20/21/22' => 'R20/21/22 - Harmful by inhalation, in contact with skin and if swallowed.',
        'R23/24' => 'R23/24 - Toxic by inhalation and in contact with skin.',
        'R24/25' => 'R24/25 - Toxic in contact with skin and if swallowed.',
        'R23/25' => 'R23/25 - Toxic by inhalation and if swallowed.',
        'R23/24/25' => 'R23/24/25 - Toxic by inhalation, in contact with skin and if swallowed.',
        'R26/27' => 'R26/27 - Very toxic by inhalation and in contact with skin.',
        'R26/28' => 'R26/28 - Very toxic by inhalation and if swallowed.',
        'R26/27/28' => 'R26/27/28 - Very toxic by inhalation, in contact with skin and if swallowed.',
        'R27/28' => 'R27/28 - Very toxic in contact with skin and if swallowed.',
        'R36/37' => 'R36/37 - Irritating to eyes and respiratory system.',
        'R36/38' => 'R36/38 - Irritating to eyes and skin.',
        'R37/38' => 'R37/38 - Irritating to respiratory system and skin.',
        'R36/37/38' => 'R36/37/38 - Irritating to eyes, respiratory system and skin.',
        'R39/23' => '39/23 - Toxic: danger of very serious irreversible effects through inhalation.',
        'R39/24' => '39/24 - Toxic: danger of very serious irreversible effects in contact with skin.',
        'R39/25' => '39/25 - Toxic: danger of very serious irreversible effects if swallowed.',
        'R39/32/24' => '39/32/24 - Toxic: danger of very serious irreversible effects through inhalation and in contact with skin.',
        'R39/23/25' => '39/23/25 - Toxic: danger of very serious irreversible effects through inhalation and if swallowed.',
        'R39/24/25' => '39/24/25 - Toxic: danger of very serious irreversible effects in contact with skin and if swallowed.',
        'R39/23/24/25' => '39/23/24/25 - Toxic: danger of very serious irreversible effects through inhalation,  in contact with skin and if swallowed.',
        'R39/26' => '39/26 - Very toxic: danger of very serious irreversible effects through inhalation.',
        'R39/26/27' => '39/26/27 - Very toxic: danger of very serious irreversible effects through inhalation and in contact with skin.',
        'R39/27' => '39/27 - Very toxic: danger of very serious irreversible effects in contact with skin.',
        'R39/28' => 'R39/28 - Very toxic: danger of very serious irreversible effects if swallowed.',
        'R39/26/28' => 'R39/26/28 - Very toxic: danger of very serious irreversible effects through inhalation and if swallowed.',
        'R39/27/28' => 'R39/27/28 - Very toxic: danger of very serious irreversible effects in contact with skin and if swallowed.',
        'R39/26/27/28' => 'R39/26/27/28 - Very toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed.',
        'R68/20' => 'R68/20 - Harmful: possible risk of irreversible effects through inhalation.',
        'R68/21' => 'R68/21 - Harmful: possible risk of irreversible effects in contact with skin.',
        'R68/22' => 'R68/22 - Harmful: possible risk of irreversible effects if swallowed.',
        'R68/20/21' => 'R68/20/21 - Harmful: possible risk of irreversible effects through inhalation  and in contact with skin.',
        'R68/20/22' => 'R68/20/22 - Harmful: possible risk of irreversible effects through inhalation  and if swallowed.',
        'R68/21/22' => 'R68/21/22 - Harmful: possible risk of irreversible effects in contact with skin  and if swallowed.',
        'R68/20/21/22' => 'R68/20/21/22 - Harmful: possible risk of irreversible effects through inhalation,  in contact with skin and if swallowed.',
        'R42/43' => 'R42/43 - May cause sensitization by inhalation and skin contact.',
        'R48/20' => 'R48/20 - Harmful: danger of serious damage to health by prolonged exposure through inhalation.',
        'R48/21' => 'R48/21 - Harmful: danger of serious damage to health by prolonged exposure in contact with skin.',
        'R48/22' => 'R48/22 - Harmful: danger of serious damage to health by prolonged exposure if swallowed.',
        'R48/20/21' => 'R48/20/21 - Harmful: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin.',
        'R48/20/22' => 'R48/20/22 - Harmful: danger of serious damage to health by prolonged exposure through inhalation and if swallowed.',
        'R48/21/22' => 'R48/21/22 - Harmful: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed.',
        'R48/20/21/22' => 'R48/20/21/22 - Harmful: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed.',
        'R48/23' => 'R48/23 -  Toxic: danger of serious damage to health by prolonged exposure through inhalation.',
        'R48/24' => 'R48/24 - Toxic: danger of serious damage to health by prolonged exposure in contact with skin.',
        'R48/25' => 'R48/25 - Toxic: danger of serious damage to health by prolonged exposure if swallowed.',
        'R48/23/24' => 'R48/23/24 - Toxic: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin.',
        'R48/23/25' => 'R48/23/25 - Toxic: danger of serious damage to health by prolonged exposure through inhalation and if swallowed.',
        'R48/24/25' => 'R48/24/25 - Toxic: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed.',
        'R48/23/24/25' => 'R48/23/24/25 - Toxic: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed.',
        'R50/53' => 'R50/53 - Very toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment.',
        'R51/53' => 'R51/53 - Toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment.',
        'R52/53' => 'R52/53 - Harmful to aquatic organisms, may cause long-term adverse effects in the aquatic environment.'
    ],

    's' => [
        'S1' => 'S1 - Keep locked up',
        'S2' => 'S2 - Keep out of the reach of children',
        'S3' => 'S3  - Keep in a cool place',
        'S4' => 'S4 - Keep away from living quarters',
        'S5' => 'S5 - Keep contents under ... (appropriate liquid to be specified by the manufacturer)',
        'S6' => 'S6 - Keep under ... (inert gas to be specified by the manufacturer)',
        'S7' => 'S7 - Keep container tightly closed',
        'S8' => 'S8 - Keep container dry',
        'S9' => 'S9 - Keep container in a well-ventilated place',
        'S12' => 'S12 - Do not keep the container sealed',
        'S13' => 'S13 - Keep away from food, drink and animal feedingstuffs',
        'S14' => 'S14 - Keep away from ... (incompatible materials to be indicated by the manufacturer)',
        'S15' => 'S15 - Keep away from heat',
        'S16' => 'S16 - Keep away from sources of ignition – No smoking',
        'S17' => 'S17 - Keep away from combustible material',
        'S18' => 'S18 - Handle and open container with care',
        'S20' => 'S20 - When using do not eat or drink',
        'S21' => 'S21 - When using do not smoke',
        'S22' => 'S22 - Do not breathe dust',
        'S23' => 'S23 - Do not breathe gas/fumes/vapour/spray (appropriate wording to be specified by the manufacturer)',
        'S24' => 'S24 - Avoid contact with skin',
        'S25' => 'S25 - Avoid contact with eyes',
        'S26' => 'S26 - In case of contact with eyes, rinse immediately with plenty of water and seek medical advice',
        'S27' => 'S27 - Take off immediately all contaminated clothing',
        'S28' => 'S28 - After contact with skin, wash immediately with plenty of (to be specified by the manufacturer)',
        'S29' => 'S29 - Do not empty into drains',
        'S30' => 'S30 - Never add water to this product',
        'S33' => 'S33 - Take precautionary measures against static discharges',
        'S35' => 'S35 - This material and its container must be disposed of in a safe way',
        'S36' => 'S36 - Wear suitable protective clothing',
        'S37' => 'S37 - Wear suitable gloves',
        'S38' => 'S38 - In case of insufficient ventilation wear suitable respiratory equipment',
        'S39' => 'S39 - Wear eye/face protection',
        'S40' => 'S40 - To clean the floor and all objects contaminated by this material use ... (to be specified by the manufacturer)',
        'S41' => 'S41 - In case of fire and/or explosion do not breathe fumes',
        'S42' => 'S42 - During fumigation/spraying wear suitable respiratory equipment (appropriate wording to be specified by the manufacturer)',
        'S43' => 'S43 - In case of fire use ... (indicate in the space the precise type of fire-fighting equipment. If water increases the risk add: Never use water)',
        'S45' => 'S45 - In case of accident or if you feel unwell seek medical advice immediately (show the label where possible)',
        'S46' => 'S46 - If swallowed, seek medical advice immediately and show this container or label',
        'S47' => 'S47 - Keep at temperature not exceeding ...°C (to be specified by the manufacturer)',
        'S48' => 'S48 - Keep wetted with ... (appropriate material to be specified by the manufacturer)',
        'S49' => 'S49 - Keep only in the original container',
        'S50' => 'S50 - Do not mix with ... (to be specified by the manufacturer)',
        'S51' => 'S51 - Use only in well-ventilated areas',
        'S52' => 'S52 - Not recommended for interior use on large surface areas',
        'S53' => 'S53 - Avoid exposure – Obtain special instructions before use',
        'S56' => 'S56 - Dispose of this material and its container to hazardous or special waste collection point',
        'S57' => 'S57 - Use appropriate containment to avoid environmental contamination',
        'S59' => 'S59 - Refer to manufacturer/supplier for information on recovery/recycling',
        'S60' => 'S60 - This material and its container must be disposed of as hazardous waste',
        'S61' => 'S61 - Avoid release to the environment. Refer to special instructions/safety data sheet',
        'S62' => 'S62 - If swallowed, do not induce vomiting: seek medical advice immediately and show this container or label',
        'S63' => 'S63 - In case of accident by inhalation: remove casualty to fresh air and keep at rest',
        'S64' => 'S64 - If swallowed, rinse mouth with water (only if the person is conscious)',
        'S1/2' => 'S1/2 - Keep locked up and out of the reach of children.',
        'S3/7' => 'S3/7 - Keep container tightly closed in a cool place.',
        'S3/9/14' => 'S3/9/14 - Keep in a cool, well-ventilated place away from … (incompatible materials to be indicated by the manufacturer).',
        'S3/9/49' => 'S3/9/49 -  Keep only in the original container in a cool, well-ventilated place.',
        'S3/9/14/49' => 'S3/9/14/49 - Keep only in the original container in a cool, well-ventilated place away from … (incompatible materials to be indicated by the manufacturer).',
        'S3/14' => 'S3/14 - Keep in a cool place away from … (incompatible materials to be indicated by the manufacturer).',
        'S7/8' => 'S7/8 - Keep container tightly closed and dry.',
        'S7/9' => 'S7/9 - Keep container tightly closed and in a well-ventilated place.',
        'S7/47' => 'S7/47 - Keep container tightly closed and at a temperature not exceeding … oC (to be specified by the manufacturer).',
        'S20/21' => 'S20/21 - When using do not eat, drink or smoke.',
        'S24/25' => 'S24/25 - Avoid contact with skin and eyes.',
        'S27/28' => 'S27/28 - After contact with skin, take off immediately all contaminated clothing, and wash immediately with plenty of … (to be specified by the manufacturer).',
        'S29/35' => 'S29/35 - Do not empty into drains; dispose of this material and its container in a safe way.',
        'S29/56' => 'S29/56 - Do not empty into drains, dispose of this material and its container at hazardous or special waste collection point.',
        'S36/37' => 'S36/37 - Wear suitable protective clothing and gloves.',
        'S36/39' => 'S36/39 - Wear suitable protective clothing and eye/face protection.',
        'S37/39' => 'S37/39 - Wear suitable gloves and eye/face protection.',
        'S36/37/39' => 'S36/37/39 - Wear suitable protective clothing, gloves and eye/face protection.',
        'S47/49' => 'S47/49 - Keep only in the original container at a temperature not exceeding … oC (to be specified by the manufacturer).'
    ]
];
