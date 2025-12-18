<?php

namespace Elecena\Utils;

/**
 * IC packages parsing utilities
 *
 * @see http://www.intersil.com/en/support/packaginginfo.html
 * @see http://www.interfacebus.com/semiconductor-transistor-packages.html
 * @see http://www.interfacebus.com/Design_Pack_types.html
 * @see https://www.torexsemi.com/technical-support/packages/
 * @see http://www.marsport.org.uk/smd/package%20equivalents.htm
 * @see http://www.topline.tv/Pin-Count.html
 * @see http://www.icpackage.org/
 * @see https://learn.sparkfun.com/tutorials/integrated-circuits/ic-packages
 * @see https://en.wikipedia.org/wiki/List_of_integrated_circuit_packaging_types
 * @see https://www.snapeda.com/discover/
 * @see https://www.jedec.org/standards-documents/focus/registered-outlines-jep95/transistor-outlines-archive
 */
class PackageInfo {

	/**
	 * @param string $desc
	 * @return string|false
	 */
	public static function getPackage(string $desc): bool|string {
		$package = false;
		$desc = mb_strtoupper($desc);

		// remove noise
		$desc = strtr($desc, '®', ' ');

		// TO220-ISO
		$desc = str_replace('-ISO', 'ISO', $desc);

		// 24 ld QFN -> 24-QFN
		$desc = preg_replace('#(\d+) LD ([A-Z]+)#', '$1-$2', $desc);

		// 32-Pin LFCSP -> LFCSP-32
		$desc = preg_replace('#(\d+)(-?pin) LFCSP#i', 'LFCSP-$1', $desc);

		// "swap" package signatures / 64-LQFP -> LQFP64
		$desc = preg_replace('#(\d+)-\s?([2A-Z]{3,})#', '$2$1', $desc);

		// "swap" package signatures / 14SOIC -> SOIC14
		$desc = preg_replace('#\s(\d+)([2A-Z]{3,})#', ' $2$1', $desc);

		// DIP 6 -> DIP-6
		$desc = preg_replace('#(\b(DIP|ZIP))\s([1-9]\d?)#', '$1-$3', $desc);

		// SOP08 -> SOP8
		$desc = preg_replace('#([A-Z]{3,})0(\d)#', '$1$2', $desc);

		// TO218AB-5pin -> TO218AB-5 pin
		$desc = preg_replace('#(\d)PIN#', '$1 PIN', $desc);

		$groups = [
			'TO-?(1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59|60|61|62|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126|127|128|129|130|131|132|201|202|203|204|205|206|206-?AA|207|208|208A|210|211|212|213AA|214|217|218|221|222|223|224|225|226|227|228|229|230|231|232|233|234|235|239|241|242|248|249|254|255|257|258|259|264|268|276)',
			// https://www.infineon.com/cms/en/product/packages/PG-TO218/
			// https://www.infineon.com/cms/en/product/packages/PG-TO218/PG-TO218-5-146/
			'TO-?218(AB-5|-5-146)',
			'SOT-?93',
			// https://en.wikipedia.org/wiki/TO-92
			'TO-?92(-3)?',
			// https://en.wikipedia.org/wiki/TO-220
			// https://www.infineon.com/cms/en/product/packages/PG-TO220/
			'I?TO-?220(AB|AC|F|FP|SG|F?[-/][2-7]C?|ISO|-ISO)?',
			'TOP-?(3)',
			// If more heat needs to be dissipated, devices in the also widely used TO-247 (or TO-3P) package can be selected / TO-3PF variant a slightly lower one / SOT429: TO-247
			// TO-3PN - https://easyeda.com/teeler123/component/TO_3PN-89Fb5nhzt
			'TO-?(247(AC|AD|-3)?|3|3P|3PF|3PN)',
			// IPAK (TO-251) package
			'TO-?251|IPAK',

			// SOT / https://www.nxp.com/packages/search?q=SOT&type=0
			'SOT-?(23|27|32|38|54|78|82|89|096|96|097|97|100|101|102|108|109|110|111|115|116|117|120|122|129|131|136|137|141|142|143|144|146|157|158|162|163|172|176|186|187|188|189|190|193|195|199|205|222|223|226|232|234|238|240|243|247|257|258|259|261|263|266|270|274|281|287|307|310|313|314|315|316|317|318|319|320|322|323|334|337|338|339|340|341|343|346|349|352|353|354|355|357|358|360|361|362|363|364|369|370|371|375|376|379|380|385|386|387|389|390|391|393|397|398|399|400|401|402|403|404|407|409|411|414|416|418|420|425|426|427|428|429|431|435|441|442|445|449|453|455|457|459|462|464|467|470|471|472|475|477|480|481|486|487|489|490|496|500|505|506|509|510|513|517|519|521|523|524|527|528|530|531|532|533|534|536|537|542|543|545|546|549|550|552|553|555|556|559|560|564|566|567|569|570|572|573|574|576|577|578|579|581|584|587|588|589|594|595|597|598|599|600|601|602|603|604|605|607|610|611|612|616|617|618|619|622|623|624|627|629|630|631|632|633|635|636|637|638|639|640|643|644|646|647|648|649|650|651|652|655|658|662|663|665|666|668|669|680|683|684|685|686|687|697|698|700|702|706|707|710|711|713|714|715|724|725|726|727|728|730|732|734|740|741|744|745|746|747|748|750|751|753|754|756|758|759|761|762|763|764|765|766|767|770|773|774|775|776|777|778|780|782|784|785|786|788|789|791|792|793|795|796|797|799|800|802|803|804|807|809|810|811|812|813|814|815|817|818|819|820|821|823|824|825|826|827|829|830|832|833|835|836|840|841|844|845|846|847|848|849|850|851|852|853|855|856|857|858|859|860|861|862|863|864|865|866|867|868|869|870|871|873|874|875|878|879|880|881|882|883|886|889|891|893|894|895|898|899|900|901|902|903|904|905|906|907|908|909|910|911|912|913|915|916|917|918|919|920|923|925|926|927|928|929|930|931|932|933|935|938|941|942|943|945|946|947|948|949|950|951|952|953|954|955|956|958|959|960|961|962|963|965|966|968|969|972|973|974|978|983|984|985|989|991|992|993|994|995|996|998|999|1000|1001|1003|1008|1011|1012|1016|1017|1018|1019|1020|1021|1022|1023|1024|1025|1026|1027|1028|1029|1031|1032|1033|1034|1035|1036|1039|1040|1041|1042|1045|1046|1047|1048|1049|1050|1051|1052|1054|1055|1056|1058|1059|1061|1062|1063|1064|1065|1067|1068|1069|1070|1071|1072|1073|1074|1075|1077|1078|1079|1080|1081|1082|1085|1086|1087|1088|1089|1090|1091|1092|1093|1094|1095|1096|1097|1098|1099|1102|1103|1104|1107|1108|1109|1113|1114|1115|1116|1118|1119|1122|1123|1128|1129|1131|1133|1134|1136|1139|1140|1141|1142|1143|1144|1145|1147|1148|1149|1150|1151|1152|1153|1154|1155|1156|1157|1158|1159|1160|1161|1162|1163|1164|1165|1166|1167|1168|1169|1172|1173|1174|1175|1176|1177|1178|1179|1180|1181|1182|1183|1184|1185|1186|1187|1188|1189|1190|1191|1192|1193|1194|1196|1197|1198|1199|1202|1203|1205|1207|1209|1210|1215|1216|1220|1222|1225|1226|1229|1230|1232|1233|1234|1235|1236|1249|1252|1254|1255|1259|1260|1261|1263|1268|1288|1289|1290|1291|1301|1302|1303|1304|1305|1306|1307|1308|1309|1310|1311|1312|1313|1314|1315|1316|1317|1318|1320|1321|1322|1323|1324|1325|1327|1328|1329|1330|1331|1332|1333|1334|1335|1336|1337|1338|1339|1340|1341|1342|1343|1344|1345|1346|1347|1348|1349|1350|1353|1354|1355|1358|1359|1360|1361|1362|1363|1365|1369|1372|1373|1375|1376|1380|1384|1390|1392|1393|1394|1397|1399|1401|1403|1404|1408|1426|1427|1428|1429|1430|1431|1432|1435|1436|1437|1438|1439|1440|1442|1443|1444|1445|1446|1447|1448|1450|1452|1453|1454|1456|1457|1458|1459|1461|1462|1463|1464|1465|1496|1510|1511|1512|1513|1514|1515|1516|1517|1518|1519|1520|1521|1522|1523|1524|1525|1526|1527|1528|1529|1530|1531|1533|1534|1535|1536|1537|1538|1539|1540|1542|1543|1544|1545|1546|1547|1548|1549|1550|1551|1552|1553|1554|1555|1556|1557|1558|1559|1560|1561|1562|1563|1564|1565|1566|1567|1569|1570|1571|1572|1573|1574|1575|1576|1577|1578|1579|1580|1581|1582|1583|1584|1585|1586|1587|1588|1589|1590|1591|1592|1593|1594|1595|1596|1597|1598|1599|1600|1601|1602|1603|1604|1605|1608|1609|1610|1611|1612|1613|1615|1616|1617|1618|1619|1620|1621|1622|1623|1624|1625|1626|1627|1628|1629|1630|1631|1632|1633|1634|1635|1636|1637|1638|1639|1640|1641|1642|1643|1644|1645|1646|1647|1648|1649|1650|1651|1652|1653|1654|1655|1656|1657|1658|1659|1660|1661|1662|1663|1664|1665|1666|1667|1668|1669|1670|1671|1672|1673|1674|1675|1676|1677|1678|1679|1680|1681|1682|1683|1684|1685|1687|1688|1691|1692|1693|1694|1695|1696|1697|1698|1699|1701|1703|1704|1705|1706|1707|1708|1709|1710|1711|1712|1713|1714|1715|1716|1717|1718|1720|1721|1722|1723|1724|1725|1726|1727|1728|1729|1730|1731|1732|1733|1734|1735|1736|1737|1738|1739|1740|1741|1742|1744|1745|1746|1747|1748|1749|1750|1751|1752|1753|1754|1756|1757|1759|1760|1761|1762|1763|1764|1765|1766|1767|1768|1769|1770|1771|1772|1773|1774|1775|1776|1777|1778|1779|1780|1781|1782|1783|1784|1785|1786|1787|1788|1789|1790|1791|1792|1793|1794|1795|1796|1797|1798|1799|1800|1801|1802|1803|1804|1805|1806|1809|1811|1812|1813|1814|1815|1816|1817|1818|1819|1821|1822|1823|1824|1825|1826|1827|1828|1829|1830|1832|1833|1834|1835|1836|1837|1838|1839|1840|1842|1843|1845|1849|1850|1851|1852|1854|1855|1856|1857|1860|1862|1863|1865|1866|1868|1870|1872|1873|1875|1877|1878|1879|1880|1882|1883|1887|1888|1890|1893|1894|1895|1896|1898|1899|1901|1903|1910|1911|1914|1917|1926|1927|1928|1936|1940|1941|1942|1945|1950)',
			'SOT-?(24|25|26|563)',
			// https://en.wikipedia.org/wiki/Small_Outline_Integrated_Circuit
			'(LF|L|M|P|V|VF)?QFP(N)?-?(100|128|144|176|208|32|44|48|52|64|80)',
			'DIL-?(4|6|8|14|16|18|20|22|24|28|32|36|40|42|48|64)',
			// https://en.wikipedia.org/wiki/Small_Outline_Integrated_Circuit
			'((H|HT|HTS|LS|M|S|T|TS|TV|Q|V|VS)?SOP?|SOIC)-?(4|5|6|8|10|12|14|16|18|20|24|28|30|32|36|38|44|48|54|56)(-J|-W|-EP|-POWERPAD)?',
			// https://en.wikipedia.org/wiki/Dual_in-line_package
			'(CERDIP|CDIP|PDIP|DIP|MDIP|EDIP)-?(4|6|8|10|12|14|16|18|20|22|24|28|32|36|40|42|48|64)',
			// Slim plastic dip" (0.3" lead spacing) versus the usual 0.4" spacing used on 28- and 40-pin packages / http://www.topline.tv/dip.html
			'SP?DIP-?(24|28|32|40|42|52|56|64)',
			'HC-?49([/-]?[US])?',
			// DO packages
			// http://www.topline.tv/DO.html / https://en.wikipedia.org/wiki/DO-204 / https://en.wikipedia.org/wiki/DO-214 / https://en.wikipedia.org/wiki/Metal_electrode_leadless_face
			// $ curl -s 'http://www.topline.tv/DO.html' | grep -oE 'DO-[0-9A-Z]+' | cut -d'-' -f 2 | sort -n | uniq | tr "\n" "|"
			'DO-?(1|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|41G|42|43|44|45|200AA|200AB|201AA|201AD|201AE|202AA|203AA|203AB|204AA|204AB|204AC|204AD|204AE|204AF|204AG|204AH|204AL|205AA|205AB|208AA|209AA|210AA|211AA|213AA|213AB|214AA|214AB|214AC|214BA|215|215AA|215AB|215AC|216|216AA|218AB|219|219AB|220|220AA|241AB|244AC)',
			'CB-?429',
			// http://www.topline.tv/DO.html
			'SOD-?(27|57|61|64|66|68|80|81|83|87|88|89|91|107|118|119|121|125)',
			// SOD323 / http://www.nxp.com/packages/SOD323
			// SOD-123, SOD-323, SOD-523 and SOD-923 / https://en.wikipedia.org/wiki/Small_Outline_Diode
			'SOD-?([1-9]23)-?(F|FL)?',
			'SC-?(90|59A)',
			'TO-?236AA',
			//  Quad Flat No-leads package / https://en.wikipedia.org/wiki/Quad_Flat_No-leads_package#Variants / http://anysilicon.com/ultimate-guide-qfn-package/
			'(CDFN|DFN|DQFN|DRMLF|LLP|LPCC|MLF|TMLF|MLPD|MLPM|MLPQ|QFN|QFN-TEP|TDFN|TQFN|UQFN|UTDFN|VQFN|WQFN|XDFN|DHVQFN|WDFN|UDFN)-?(4|5|6|8|10|12|14|16|20|24|28|32|38|40|44|48|52|56|64|68|80|100|112|120|128|144|176|208)-?(EP|S)?',
			// Quad Flat Package / https://en.wikipedia.org/wiki/Quad_Flat_Package
			'(BQFP|BQFPH|CQFP|EQFP|FQFP|LQFP|MQFP|NQFP|SQFP|TDFP|TQFP|VQFP|VTQFP|HTQFP)[- ]?(4|5|6|8|10|14|16|20|24|28|32|38|40|44|48|52|56|64|68|80|100|112|120|128|144|176|208)',
			// https://en.wikipedia.org/wiki/Small-outline_transistor / Many manufacturers[1][2] also offer the nearly identical thin small outline transistor (TSOT)
			'T?SOT-?(23|26)-?(3|5|6|8)?L?',
			'SC-?70-?(3|4|5|6)?',
			'SOT-?416FL',
			'EMT3F',
			'SC-?89',
			'TSOT-?5',
			'TO-?253',
			// http://www.smdmark.com/en-US/ic-201725.html
			'T-?63',

			// The SOT-227, or sometimes referred to as the ISOTOP® package
			'(SOT-?227(B|-4)?)|ISOTOP',
			// https://en.wikipedia.org/wiki/Small-outline_transistor#SOT223_.28.3DSOT223-4.29 / http://www.nxp.com/packages/SOT223
			'SOT-?223-?(2|3|4|5|6|8)?L?',
			'(SC-?73)|(TO-?261AA)|(SM-?8)',
			// https://en.wikipedia.org/wiki/Small-outline_transistor#SOT89-3
			'SOT?-89-?(3|4|5)?',
			// http://www.ferret.com.au/c/richardson-electronics/100v-mosfet-modules-in-sp3-sp4-sp6-packages-n679793 / mosfet modules
			'SP(1|3|4|6|6-P)',
			// Clipwatt
			'CLIPWATT(-|\s)?(11|15|19)',
			// Ball Grid Array / https://en.wikipedia.org/wiki/Ball_grid_array
			'(BGA|CABGA|CSPBGA|DSBGA|FBGA|FCBGA|FCPBGA|FPBGA|FTBGA|HBGA|PBGA|TBGA|TFBGA|TWBGA|UBGA|VFBGA)-?(4|5|6|48|63|64|90|96|108|113|119|121|132|144|165|191|208|256|324|400|480|484|672|676|780|783|896|900|1152|1156|1517|1704|1760|1932)',
			// DPAK (TO-252) / https://en.wikipedia.org/wiki/TO-263
			'(D-?PAK|D2PAK|DDPAK)-?(3|5)?',
			'TO-?(252|252-3|252-5|263|263-5)(AA|AB)?',
			// I2PAK (TO-262) PACKAGE / https://www.vishay.com/mosfets/i2pak-to-262-package/
			'I2PAK',
			// SON
			'(PG-TD|W|V|X|X2)?SON-?(4|6|8|10)',
			// Leadframe Chip Scale Package / https://en.wikipedia.org/wiki/Chip-scale_package
			'(LFCSP|CSP|FCCSP|CSP|WL-CSP)-?(8|10|16|20|24|32|48|64)-?(VQ|WD|WQ)?',
			// Chip carrier / https://en.wikipedia.org/wiki/Chip_carrier
			'(BCC|CLCC|LCC|LCCC|DLCC|PLCC)-?(4|6|8|10|20|28|32|44|52|68|84)',
			// μMAX seems to be a package solely used by Maxim. It's an 8 pin SMT package, about as wide as an SO-8, but just 3mm long instead of the 5mm of an SO-8
			'(UMAX|USOP)-?(8|10)',
			// Torex packages / https://www.torexsemi.com/technical-support/packages/
			'USP(N|Q)?-?(3|4|6|10)(B|B03)?',
			// SOT-416 (or SOT-523 / SOT-75) / http://www.nxp.com/packages/SOT416.html
			'SC-?75A?',
			// MinSO [STMicroelectronics] / http://pl.mouser.com/Semiconductors/Amplifier-ICs/Analog-Comparators/_/N-cib1w?P=1z0xw9w&pop=1wwj
			'MINISO-?(8)',
			// Melf / https://en.wikipedia.org/wiki/Metal_electrode_leadless_face
			'MM(A|B|U)',
			'(MICRO|MINI)?(-|\s)?MELF',
			// SSOT packages / http://www.marsport.org.uk/smd/package%20equivalents.htm
			'SSOT-?(24|25|26|457)',
			'SMQ|SM6|SMV|SC-?74',
			// TO-277 (Z3) / TO-277A (SMPC)
			'TO-?277A?',
			'Z3|SMPC',
			// TO-262
			'TO-?262(AA)?',
			// SIL/SIP/SILP package / https://sites.google.com/site/nhecomponents/components-index/integrated-circuits/la-series
			'SI(L|P|LP)-?(5|7|9|10|11|12|13|14|15|16|17|18|23|25|30)',
			// ZIP - Zig-zag in-line package
			'ZIP-?(5|9|15|20|24|40)',
			// Pentawatt / https://easyeda.com/antonellapuricelli99/component/Pentawatt_V-GEZvN5nFz & https://easyeda.com/Junikos/component/PENTAWATT-lHBTNHYgy
			// http://www.marcospecialties.com/pinball-parts/VN02N
			// TO-220-5 / https://github.com/KiCad/TO_SOT_Packages_THT.pretty/blob/master/TO-220-5_Pentawatt_Multiwatt-5_Vertical_StaggeredType1.kicad_mod
			'PENTAWATT(-V)?',
			// TO-202 is a type of plastic-molded package that features a flat metal tab at its back / http://eesemi.com/to202.htm
			'TO-?202(-[13])?',
			// RD91 package is for wire connections via direct soldering or push-on terminals
			'RD-?(91)',
			// SQL package
			'SQL-?(5|9|11|12|15|17|23)',
			// https://www.nxp.com/packages/SOT399 / SOT399: TOP-3D - plastic single-ended through-hole package; mountable to heatsink; 1 mounting hole; 3 in-line leads
			'TOP-?3D',
			// ISO package
			'ISO-?218',
			// LoPak and others
			'LOPAK',
			'T-MAX',

			// for normalization
			'SC-?67',
		];
		$pattern = '#(^|-|,|:|\s|$|\[|\(|/)(' . join('|', $groups) . ')(\)|]|;|,|=|\s|/|$)#';

		if (preg_match(
			$pattern,
			$desc,
			$matches)
		) {
			$package = $matches[2];

			$package = str_replace(' ', '', $package); # remove spaces in 'CLIPWATT 19' => 'CLIPWATT19'
			$package = str_replace('/', '', $package); # remove slashes in HC49/U
			$package = preg_replace('#([A-Z])-([A-Z\d]+)#', '$1$2', $package); # remove dash in DIL-14 -> "DIL14"
			$package = preg_replace('#(TO|DO|CLIPWATT)(\d+)#', '$1-$2', $package); # add dash to TO92, DO-14 and CLIPWATT19 -> "TO-92"

			/**
			 * Normalize packages
			 *
			 * @see http://www.topline.tv/DO.html
			 *
			 * The DO-7 (also known as DO-204-AA)
			 * The DO-35 (also known as DO-204-AH or SOD27)
			 * The DO-41 (also known as DO-204-AL or SOD66)
			 */
			# var_dump($package);

			$normalizations = [
				'DO-204AA' => 'DO-7',
				'DO-204AH' => 'DO-35',
				'SOD27' => 'DO-35',
				'DO-204AL' => 'DO-41',
				'SOD66' => 'DO-41',

				// general purpose Zener diodes in a SOD323F (SC-90)
				'SC90' => 'SOD323F',

				// https://en.wikipedia.org/wiki/Small-outline_transistor
				'SOT23' => 'SOT23-3',
				'SOT323' => 'SOT23-3',
				'TO-236AA' => 'SOT23-3',
				'SC59A' => 'SOT23-3',
				'SOT353' => 'SOT23-5',
				'SOT363' => 'SOT23-6',
				'SOT28' => 'SOT23-8',
				'TSOT5' => 'TSOT23-5',
				'SC70-3' => 'SOT23-3',
				'SC70-5' => 'SOT23-5',
				'SC70-6' => 'SOT23-6',
				'SC89' => 'SOT490',
				'SOT416FL' => 'SOT490',
				'EMT3F' => 'SOT490',
				'TO-253' => 'SOT143',
				'SMQ' => 'SOT24',

				// TO-220F also known as the SOT186 and SC67 is TO-220 like package, where the heatsink mounting tab has been encased in the plastic
				'SOT186' => 'TO-220F',
				'SC67' => 'TO-220F',

				// https://www.nxp.com/packages/SOT82 / SIP3; TO-220(JEDEC)
				'SOT82' => 'TO-220',

				// The SOT-227, or sometimes referred to as the ISOTOP® package
				'ISOTOP' => 'SOT-227',
				'SOT227' => 'SOT-227',
				'SOT227-4' => 'SOT-227',
				'SOT227B' => 'SOT-227B',

				// http://www.smdmark.com/en-US/ic-201725.html
				'T63' => 'SOT-23',

				// https://en.wikipedia.org/wiki/Small-outline_transistor#SOT89-3
				'SOT89' => 'SOT89-3',
				'SOT89-4' => 'SOT89-3', // Some call this package a SOT89-4, since it visually appears to have four leads when looking down at the part.

				// https://en.wikipedia.org/wiki/Small-outline_transistor#SOT223_.28.3DSOT223-4.29
				'SC73' => 'SOT223',
				'TO-261AA' => 'SOT223',
				'SM8' => 'SOT223-8',

				// TO-252 is known as DPAK (Decawat Package)
				// Package can have 3 pins with 90 mils pitch, or 5 pins with 45 mils pitch.
				// @see https://en.wikipedia.org/wiki/TO-252
				'DPAK' => 'TO-252',
				'TO-252AA' => 'TO-252',

				// TO-251: Also called IPAK: SMT package similar to the DPAK but with longer leads for SMT or TH mounting
				'IPAK' => 'TO-251',

				// TO-263 is known as DDPAK
				// @see https://en.wikipedia.org/wiki/TO-263
				'DDPAK' => 'TO-263',
				'DDPAK3' => 'TO-263',
				'DDPAK5' => 'TO-263',
				'D2PAK' => 'TO-263',

				// I2PAK (TO-262)
				// https://www.vishay.com/mosfets/i2pak-to-262-package/
				'I2PAK' => 'TO-262',

				// ... widely used TO-247 (or TO-3P)
				// @see http://www.nxp.com/packages/SOT429.html
				'TO-3' => 'TO-247',
				'TO-3P' => 'TO-247',
				'SOT429' => 'TO-247',

				// SOT-93 is a through-hole mount package between TO-220 and TO-247 in terms of package size | TO-218 / SOT-93
				// @see http://www.psitechnologies.com/products/to218.php
				'SOT93' => 'TO-218',

				// SOT416: SC-75 / SOT-523
				'SOT523' => 'SOT416',
				'SC75' => 'SOT416',
				'SC75A' => 'SOT416',

				'SMV' => 'SOT25',
				'SM6' => 'SOT26',
				'SC74' => 'SOT457',

				'TOP3D' => 'SOT399',

				'SMPC' => 'TO-277A',

				// Melf
				'MINIMELF' => 'MiniMELF',
				'MICROMELF' => 'MicroMELF',
				'MMA' => 'MiniMELF',
				'MMB' => 'MELF',
				'MMU' => 'MicroMELF',

				// http://www.irf.com/part/55V-DUAL-N-CHANNEL-DIGITAL-AUDIO-HEXFET-POWER-MOSFET-IN-A-TO-220-FULL-PAK-ISO-PACKAGE/_/A~IRFI4024H-117P
				'TO-220ISO' => 'TO-220 Full-Pak',
				'TO-2202' => 'TO-220-2',
				'TO-2203' => 'TO-220-3',
				'TO-2204' => 'TO-220-4',
				'TO-2205' => 'TO-220-5',
				'TO-2206' => 'TO-220-6',
				'TO-2207' => 'TO-220-7',
				'TO-220F4' => 'TO-220F-4',

				// LFCSP
				'LFCSP8' => 'LFCSP-8',
				'LFCSP10' => 'LFCSP-10',
				'LFCSP16' => 'LFCSP-16',
				'LFCSP32' => 'LFCSP-32',

				// Pentawatt
				'PENTAWATTV' => 'PENTAWATT-V',
				'TO-220-5' => 'PENTAWATT',

				// TO-206-AA
				// @see https://en.wikipedia.org/wiki/TO-18
				// @see https://www.arrow.com/en/products/2n2222a/microsemi
				'TO-206-AA' => 'TO-18',

				// @see https://www.infineon.com/cms/en/product/packages/PG-TO218/
				'TO-218AB5' => 'TO-218AB-5',

				// http://www.taydaelectronics.com/1-5ke6v8-tvs-bidirectional-6-8v-1500w-cb429-do-201ad-1-5ke6v8ca.html
				'CB429' => 'DO-201AD',

				// normalize LoPak, T-Max, ...
				'LOPAK' => 'LoPak',
				'TMAX' => 'T-Max',
			];

			if (array_key_exists($package, $normalizations)) {
				$package = $normalizations[$package];
			}
		}
//		else {
//			var_dump(__METHOD__, $desc, $package); // debug
//		}
		return $package;
	}
}
