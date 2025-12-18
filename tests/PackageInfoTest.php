<?php

use Elecena\Utils\PackageInfo;
use PHPUnit\Framework\TestCase;

/**
 * Set of integration tests for the PackageInfo class.
 */
class PackageInfoTest extends TestCase {

	/**
	 * @param string $desc
	 * @param string $expected
	 *
	 * @dataProvider getPackageProvider
	 */
	public function testGetPackage($desc, $expected) {
		$this->assertEquals($expected, PackageInfo::getPackage($desc), "{$desc} should be detected as {$expected}");
	}

	/**
	 * @return array
	 */
	public static function getPackageProvider() {
		return [
			[ 'foo', false ],

			[ 'Tranzystor: NPN; bipolarny; 80V; 7A; 40W; TO220', 'TO-220' ],
			[ 'Tranzystor: NPN; bipolarny; 80V; 7A; 40W; to220', 'TO-220' ],
			[ 'Tranzystor: NPN; bipolarny; 80V; 7A; 40W; to-220', 'TO-220' ],
			[ 'Obudowa: TO220SG=0.6mm', 'TO-220SG' ],

			[ 'BT136 (TO-220F)', 'TO-220F' ],
			[ '2SA1538 Tranzystor PNP 120V 0,2A 8W 400MHz SOT186', 'TO-220F' ],
			[ 'TK15A50 500V 15A 0,24R n-mosfet SC67', 'TO-220F' ],
			[ 'MOSFET,N CHANNEL,600V,3.7A,SC-67', 'TO-220F' ],
			[ 'Stabilizator napięcia; nieregulowany; 5V; 0,5A; TO220AB; THT', 'TO-220AB' ],
			[ 'TRIAC 800V 10A TO-220FP', 'TO-220FP' ],
			[ '7806CV 1,5A TO220(Single Gauge=0.6mm) * Liczba w opakowaniu:50 * Obudowa:TO220SG=0.6mm', 'TO-220SG' ],
			[ 'DIODE ARRAY SCHOTTKY 45V ITO220', 'ITO-220' ],
			[ 'Tranzystor 2SC5171 NPN, obudowa TO-220-3 Vce - 180V Ic - 2A para komplementarna z tranzystorem 2SA1930', 'TO-220-3' ],
			[ 'Tranzystor 2SC5171 NPN, obudowa TO-220-3 Vce - 180V Ic - 2A para komplementarna z tranzystorem 2SA1930', 'TO-220-3' ],

			[ 'KIA-78R05-PI TO-220F-4 ISO STABILIZATOR', 'TO-220F-4' ],
			[ '5pcs KIA278R12 TO220F-4 278R12 TO220-4 KIA278R12PI TO-220F', 'TO-220F-4' ],
			[ 'KA-78R05F TO-220-4 ISO STABILIZATOR', 'TO-220-4' ],
			[ '5V 1A 78R05 (=KIA278R05) TO-220/4 IZOLOWANY STABILIZATOR Z RESETEM', 'TO-220-4' ],
			[ 'LM2595T-12 TO-220-5 2pcs', 'PENTAWATT' ],
			[ 'TOP-258-YN TO-220/6 UKŁAD', 'TO-220-6' ],
			[ 'UKŁAD SCALONY TOP258YN TO220-7C , 6PIN', 'TO-220-7C' ],

			[ 'Triak BT136X-800 4A/800V/70mA TO220ISO', 'TO-220 Full-Pak' ],
			[' 2SC4234 Tranzystor NPN 1200V 3A 45W 8MHz TO220-ISO', 'TO-220 Full-Pak' ],

			[ 'Triak BT134-600D 4A/600V SOT82', 'TO-220' ],
			[ 'Triak BT134-600E 4A/600V TO126/SOT82', 'TO-126' ],

			[ 'Tranzystor PNP 100 V 25 A 3 MHz HFE 10 TO-247 TIP36C 3-Pin', 'TO-247' ],
			[ 'BU626A TO-3', 'TO-247' ],
			[ 'Dioda FYA3010DNTU 30A 100V TO-3P 3-Pin', 'TO-247' ],
			[ '2SC3320 TO-3P TRANSISTOR', 'TO-247' ],
			[ '2SC-3421 NPN 1A/120V/10W SOT-429 TRANZYS', 'TO-247' ],
			[ 'TRANS NPN DARL 400V 15A TO-247-3', 'TO-247-3' ],
			[ 'TRANSISTOR, BIPOLAR, NPN, 600V, 96A, TO-247AC', 'TO-247AC' ],
			[ 'DIODE SCHOTTKY 40A 200V TO-247AD', 'TO-247AD' ],
			[ 'IGBT 600V 24A 54W TO-3PF', 'TO-3PF' ],
			[ '2SK2313 TOSHIBA K2313 Transistor MOSFET N-CH 60V 60A TO-3PN', 'TO-3PN' ],
			[ 'IRFP460C Tranzystor 235W TO-3PN N-Channel', 'TO-3PN' ],

			[ 'Tranzystor: NPN; bipolarny; 60V; 600mA; 350mW; TO92', 'TO-92' ],
			[ 'Tranzystor: NPN; bipolarny; 60V; 600mA; 350mW; TO-92', 'TO-92' ],
			[ '2SJ74 (TO-92)', 'TO-92' ],
			[ 'Układ nadzorujący, reset aktywny w stanie niskim, 1V-5.5Vin, TO-92-3', 'TO-92-3' ],

			[ 'Tranzystor: NPN; TO39; bipolarny; 75V; 500mA; 800mW', 'TO-39' ],
			[ 'TO39; bipolarny; 75V; 500mA; 800mW', 'TO-39' ],

			[ 'Tranzystor BC107 NPN 45V-100mA-300mW obudowa:TO-18', 'TO-18' ],
			[ 'BC107B TO-18', 'TO-18' ],
			[ 'BC107 TO-18 NPN 100mA 45V 300mW', 'TO-18' ],
			[ '2N2222A Trans GP BJT NPN 50V 0.8A 3-Pin TO-206-AA', 'TO-18' ], // alias

			# various TO packages
			[ 'Tyrystor; T50N12; 50A; 1200V; TO48 M6; przykręcany; Greegoo', 'TO-48' ],
			[ 'Tyrystor; 50RIA120M; 50A; 1200V; TO65 M6; przewlekany (THT); 200mA; Greegoo; RoHS', 'TO-65' ],
			[ 'Wzmacniacz operacyjny OPA128LM 1MHz TO-99, 8-Pin', 'TO-99' ],

			# I2PAK (TO-262)
			[ 'STD1NK60-1 Tranzystor: N-MOSFET; unipolarny; 600V; 0,63A; 30W; I2PAK', 'TO-262' ],
			[ 'IPI65R310CFD high voltage CoolMOS™ MOSFETs with integrated fast body diode I2PAK' , 'TO-262' ],
			[ 'IPI80N06S4L07AKSA1 Trans MOSFET N-CH 60V 80A Automotive 3-Pin(3+Tab) TO-262 Tube', 'TO-262' ],

			# T packages
			[ 'Tyrystor; T63-200-04-50; 200A; 400V; T63; przykręcany; Lamina', 'SOT-23' ],

			[ 'BTA26-600BRG TRIAC 600V 25A TOP3', 'TOP3' ],
			[ '2SK2370 NEC MOSFET 500V 20A TOP-3 TRANSISTOR', 'TOP3' ],

			[ 'MOSFET 2N-CH 1200V 34A SP4', 'SP4' ],
			[ 'MOSFET 6N-CH 600V 116A SP6-P', 'SP6-P' ],

			// SOT packages / https://www.nxp.com/packages/search?q=SOT&type=0
			[ 'IGBT 1200V 35A 260W SOT-227', 'SOT-227' ],
			[ 'MOD THYRISTOR SGL 1200V SOT-227B', 'SOT-227B' ],
			[ 'MOD THYRISTOR SGL 1200V SOT-227B', 'SOT-227B' ],
			[ 'ISOTOP®', 'SOT-227' ],
			[ 'SOT-227-4 N-Channel 600 V MOSFET', 'SOT-227' ],

			[ 'Dioda Schottky dual 30V 0,07A 0,8ns 0,55V CA/C SOT490', 'SOT490' ],
			[ 'TRANS PREBIAS NPN 50V 0.15W SC89', 'SOT490' ],
			[ 'TRANS PREBIAS NPN 50V EMT3F', 'SOT490' ],
			[ 'Tranzystor PNP -50 V 100 mA 100 MHz HFE 120 SOT-416FL 2SAR523EBTL 3-Pin', 'SOT490' ],

			[ 'Tranzystor dual NPN 30V 0,1A 0,25W 100MHz SOT143' ,'SOT143' ],
			[ 'Dioda prostownicza, Jedna, 80 V, 100 mA, TO-253, 1.2 V, 4 piny/-ów', 'SOT143' ],
			[ 'TRANS RF NPN 12V 80MA SOT343', 'SOT343' ],

			[ 'BU2525AX NPN 800V 12A 45W SOT399', 'SOT399' ],
			[ 'TRANZYSTOR NPN 1500V 12A 45W IZOLOWANY TOP3D', 'SOT399' ],

			[ 'BU2525AF SOT199', 'SOT199' ],
			[ 'IC GATE OR SGL 2-INPUT SOT953', 'SOT953' ],

			[ 'Pamięć; EEPROM; I2C; 128x8bit; 1,8÷5,5V; 400kHz; DFN8', 'DFN8' ],

			[ 'Pamięć; EEPROM; UNI/O; 256x8bit; 1,8÷5,5V; 100kHz; MSOP8', 'MSOP8' ],
			[ 'Mikrokontroler ARM; Flash:200kB; SRAM:16kB; 32MHz; PG-TSSOP-38', 'TSSOP38' ],
			[ 'Pamięć; EEPROM; I2C; 128x8bit; 1,7÷5,5V; 400kHz; TSSOP8', 'TSSOP8' ],
			[ 'Nadajnik-odbiornik linii; RS232 / V.28; 4,5÷5,5VDC; SSOP20', 'SSOP20' ],

			[ '24C16N-10SI 2,7 Atm  SOP08', 'SOP8' ],

			[ 'Odbiornik linii; RS232; L.odb:4; 4,5÷5,5VDC; SO14; 0÷75°C', 'SO14' ],
			[ 'Nadajnik-odbiornik linii; RS232,full duplex; 4,5÷5,5VDC; SO16', 'SO16' ],
			[ 'Odbiornik linii; RS422,RS423; L.odb:4; 4,5÷5,5VDC; SO16; -40÷85°C', 'SO16' ],
			[ 'Nadajnik-odbiornik linii; RS422 / RS485; 5VDC; SO8-W', 'SO8-W' ],
			[ 'L6386AD (L6386 AD) SO-14', 'SO14' ],
			[ 'L6386 SMD (SOP-14)', 'SOP14' ],
			[ 'OP-AMP, DIFFERENTIAL, 350MHZ, 1200V\/us, MSOP-8', 'MSOP8' ],
			[ 'Monitor napięcia, 3.5V-100Vin, MSOP-16', 'MSOP16' ],
			[ '10-MSOP-EP', 'MSOP10-EP' ],
			[ '10-MSOP-PowerPad', 'MSOP10-POWERPAD' ],
			[ 'IC REG LDO 3.3V 1A 8-HTSOP-J', 'HTSOP8-J' ],
			[ 'Operational Amplifiers - Op Amps TLVx314 3-MHz, Low-Power, Low-Noise, RRIO, CMOS Operational Amplifiers 8-VSSOP -40 to 125', 'VSSOP8' ],
			[ 'IC DIRECT RAMBUS CLK GEN 24-QSOP', 'QSOP24' ],

			[ 'ATTINY10-TS8R Mikrokontroler AVR; SRAM:32B; Flash:1kB; SOT23-6; Uzas:1,8÷5,5V', 'SOT23-6' ],
			[ 'MCP3421A0T-E/CH - 18-bitowy przetwornik A/D SMD SOT23-6 PBF', 'SOT23-6' ],
			[ 'IC LDO 300MA LOW IQ TSOT-23-5', 'TSOT23-5' ],
			[ 'Układ napięcia odniesienia, precyzyjny, szeregowy - stały, seria LT6656, 5V, TSOT-23-6', 'TSOT23-6' ],
			[ 'DC-DC Switching Buck Regulator, Adjustable, 4.5 V-18 Vin, 0.6 V-5 V/4 A out, 500 kHz, TSOT-23-8', 'TSOT23-8' ],
			[ 'IC OPAMP VFB 90MHZ RRO TSOT-5', 'TSOT23-5' ],
			[ 'IC BUFFER TRI-ST NON-INV SOT353', 'SOT23-5'],
			[ 'Przetwornica DC/DC; boost; Vout: 1.8-5.5V; Vin: 0.65-5.5V; 0.4A; 500kHz; -40+85 st.C; SMD; SOT23-6L', 'SOT23-6L' ],
			[ 'Dioda przełączająca BAV756S, 6-Pin, SMD, 90V, 250mA, 1MHz, -65 → +150°C, SOT-363', 'SOT23-6' ],
			[ 'Przetwornica DC/DC; Vout: 0.8-26V; Vin: 4.5-40V; 600mA; 2MHz; -40+85 st.C; SMD; TSOT26', 'TSOT26' ],

			[ 'TRANS NPN 80V 1A SOT-89', 'SOT89-3' ],
			[ 'MOSFET, N CHANNEL, 300V, 0.2A, SOT-89-3' ,'SOT89-3' ],
			[ 'RF Amplifier IC, 21 dB Gain / 4.5 dB Noise, DC to 4 GHz, 5 V supply, SOT-89-4', 'SOT89-3' ],
			[ 'IC LDO 0.2A LOW DROPOUT SOT-89-5', 'SOT89-5' ],

			[ '2SK956 Tranzystor N-MOSFET 800V 9A 150W 1R5 SOT93', 'TO-218' ],
			[ 'Transistor NPN TO-218 60 V 15 A 90 W', 'TO-218' ],
			[ 'BTS555 MOSFET 165A/62V driver TO218AB-5pin', 'TO-218AB-5' ],
			[ 'BTS555 Transistor N Channel MOSFET Case TO218AB-5' ,'TO-218AB-5' ],
			[ 'IC SW PWR HISIDE TO-218-5-146', 'TO-218-5-146' ],

			[ 'BSP52E6327 INFIN 0205 SOT223', 'SOT223' ],
			[ 'PNP high-voltage low VCEsat Breakthrough In Small Signal (BISS) transistor in a SOT223 (SC-73) medium power', 'SOT223' ],
			[ 'Tranzystor NPN 350 V 100 mA 70 MHz HFE 40 TO-261AA BSP19AT1G 3-Pin', 'SOT223' ],
			[ 'Stabilizator napięcia; nieregulowany; 6V; 3,3V; 500mA; SOT223-5', 'SOT223-5' ],
			[ 'LDO VOLTAGE REGULATOR, 1.8V, 0.4A, SOT-223-6, FULL REEL', 'SOT223-6' ],
			[ 'ZXMHC6A07T8TA N & P CHANNEL MOSFET, -60V, SM-8', 'SOT223-8' ],
			[ 'MOSFET 2N-CH 60V 2A SOT-223-8', 'SOT223-8' ],
			[ 'Super Junction MOSFET, C2, SOT-223-2L, 2,6A, 700V, 2,55Ohm , 4,6W , 30V, 3,3V, WAYON' , 'SOT223-2L' ],
			[ 'Dioda: prostownicza; SMD; 70V; 200mA; 6ns; 200mW; SC70; Ifsm:500mA', 'SC70' ],
			[ 'Dioda transil drabinka ESD 5,5V 2A SC70-3' ,'SOT23-3' ],
			[ 'MOSFET Pch Power MOS FET SC-59A/TO-236AA', 'SOT23-3' ],
			[ 'MOS FET SC-59A', 'SOT23-3' ],
			[ 'MOSFET TO236AA', 'SOT23-3' ],
			[ 'Dioda: drabinka diodowa; 6V; 6A; jednokierunkowa; 150W; SC70-5', 'SOT23-5' ],
			[ 'Dioda: drabinka diodowa; SC70-6; 150W; 6A; Ubr:6V; Urmax:5V', 'SOT23-6' ],

			[ 'UKŁAD SCALONY AN6165SB SMD SOT24', 'SOT24' ],
			[ 'TRANS RF NPN 12V 1MHZ SMQ', 'SOT24' ],
			[ 'Stabilizator MM3291CN SOT-25', 'SOT25' ],
			[ 'TRANS 2PNP PREBIAS 0.3W SMV', 'SOT25' ],
			[ 'HMC197B GaAs MMIC SOT26 SPDT Switch, DC - 3 GHz', 'SOT26' ],
			[ 'TRANS 2NPN PREBIAS 0.3W SM6', 'SOT26' ],
			[ 'Diode SOT17', false ],

			[ 'Sieć tranzystorów bipolarnych, NPN, 50 V, 300 mW, 100 mA, 30 hFE, SOT-457', 'SOT457' ],
			[ 'Tranzystor: NPN / PNP; bipolarny; komplementarne; 80V; 500mA; SC74', 'SOT457' ],
			[ 'TRANSISTOR DUAL, 50V, PNP/PNP, SC-74', 'SOT457' ],

			[ 'DIODE AVALANCHE 200V 2A SOD57', 'SOD57' ],
			[ 'BYD37M PRODUCENT / MANUFACTURER: PHILIPS OBUDOWA / PACKAGE: SOD-87 FAST SOFT-RECOVERY CONTROLLED', 'SOD87' ],

			[ 'Nadajnik linii; RS422,RS485; L.nad:4; DIP16; 4,75÷5,25VDC; 0÷70°C', 'DIP16' ],
			[ 'Nadajnik-odbiornik linii; RS422 / RS485; 5VDC; DIP8', 'DIP8' ],
			[ 'Pamięć; EEPROM; UNI/O; 128x8bit; 1,8÷5,5V; 100kHz; DIP-8', 'DIP8' ],
			[ 'Transoptor 4N37 z tranzystorem 1-kanałowy DC DIP 6 Vishay', 'DIP6' ],
			[ 'IC VREF SERIES PREC 5V 8-CERDIP', 'CERDIP8' ],
			[ 'IC FPS POWER SWITCH 650V 8-MDIP', 'MDIP8' ],
			[ '24C128-10PI-2,7 Atm PDIP08', 'PDIP8' ],
			[ 'LNK6769V IC LINKSWITCH 39W 54W 12-EDIP', 'EDIP12' ],
			[ 'TODX283 PRODUCENT / MANUFACTURER: TOSHIBA OBUDOWA / PACKAGE: DIP-10 OPTOELECTRONIC', 'DIP10' ],
			[ 'FOO DIP-11', false ],

			[ 'LA7116 - układ scalony SDIP24', 'SDIP24' ],
			[ 'PIC16C55A-04/SP 8-bit Microcontrollers - MCU .75KB 24 RAM 20 I/O 4MHz SPDIP-28', 'SPDIP28' ],
			[ 'PIC32MX230F256B-I/SP MCU, 32BIT, PIC32MX, 50MHZ, SDIP-28', 'SDIP28' ],
			[ 'M50780SP PRODUCENT / MANUFACTURER: MITSUBISHI OBUDOWA / PACKAGE: SDIP-40', 'SDIP40' ],
			[ 'FOO SDIP-16', false ],
			[ 'DIP-10', 'DIP10' ],
			[ 'DIP 10', 'DIP10' ],
			[ 'DIP10', 'DIP10' ],

			[ 'Układ scalony MAX7219CNG [DIL-22]', 'DIL22' ],
			[ 'Mikrokontroler AVR-RISC Atmel ATTINY26-16PU, DIL-20, 0 - 16 MHz Flash: 2 kB, RAM: 128', 'DIL20' ],
			[ 'Atmega16A-PU DIP40', 'DIP40' ],

			[ 'DIP-4 HV CPL 10kV 600mil 50-300% CTR -e4', 'DIP4' ],
			[ 'DIP-6 CPL 40-80% CTR -e3', 'DIP6' ],

			[ 'Mikrokontroler ARM; Flash:64kB; SRAM:16kB; 48MHz; PG-LQFP-64', 'LQFP64' ],
			[ 'LQFP 144 20x20x1.4', 'LQFP144' ],

			[ 'Kwarc, rezonator kwarcowy 49,95416MHz [HC-49U]', 'HC49U' ],
			[ '40.00 MHZ Rezonator: kwarcowy; 40MHz; 30ppm; 16pF÷30pF; THT; HC49/U 100ST 100', 'HC49U' ],
			[ 'Rezonator: kwarcowy; 12MHz; ±30ppm; 30pF; THT; HC49-S', 'HC49-S' ],
			[ 'Rezonator: kwarcowy; 12MHz; ±30ppm; 30pF; THT; HC49-S', 'HC49-S' ],
			[ 'Rezonator: kwarcowy; 12,288MHz; ±30ppm; 16pF÷30pF; THT; HC49/U', 'HC49U' ],
			[ 'Rezonator kwarcowy 16MHz - HC49 - niski', 'HC49' ],
			[ 'HC49/4HSMX 30/50/20/18 30 MHZ - Kryształ, 30 MHz, SMD, 11.4mm x 4.9mm, 50 ppm, 18 pF, 30 ppm, Seria HC-49/4HSMX', 'HC49' ],

			[ 'STA540SA (STA540 SA) Clipwatt-19', 'CLIPWATT-19' ],
			[ 'STA540SAN (STA540 SAN) Clipwatt-15', 'CLIPWATT-15' ],
			[ 'STA540SA CLIPWATT-19', 'CLIPWATT-19' ],
			[ 'STA540SA (STA540 SA) 4 x 10-watt dual/quad power amplifier Clipwatt 19', 'CLIPWATT-19' ],
			[ 'STV-9556 CLIPWATT-11 RGB AMPLIFIER UKŁAD', 'CLIPWATT-11' ],
			[ 'TDA-7269-SA CLIPWATT-11 UKŁAD', 'CLIPWATT-11' ],

			[ 'ATMEGA64-16AU Obudowa:TQFP64', 'TQFP64' ],
			[ '100-TQFP (14x14)', 'TQFP100' ],
			[ '128-TQFP (10x10)', 'TQFP128' ],
			[ '144-TQFP', 'TQFP144' ],
			[ '32-TQFP', 'TQFP32' ],
			[ '44-TQFP', 'TQFP44' ],
			[ '48-HTQFP', 'HTQFP48' ],
			[ '48-TQFP', 'TQFP48' ],
			[ '64-HTQFP', 'HTQFP64' ],
			[ '64-TQFP', 'TQFP64' ],
			[ '80-TQFP', 'TQFP80' ],

			[ 'Transceiver, 74LVC8T245, 1.2 V do 5.5 V, DHVQFN-24', 'DHVQFN24' ],
			[ 'MAX3840ETJ Crosspoint Switch, Dual Interface, 2x2 Array, +3 V to +3.6 V, TQFN-32', 'TQFN32' ],
			[ 'MAX8662ETM IC POWER MANAGE 48-TQFN-EP', 'TQFN48-EP' ],
			[ 'LMK03328RHST "Clock Generator, 300 MHz, 3.135 V to 3.465 V, 8 Outputs, WQFN-48', 'WQFN48' ],
			[ 'DSPIC33EP16GS202-I/MX DSC, 16BIT, 16KB, 140MHZ, 3.6V, UQFN-28', 'UQFN28' ],

			[ 'Battery monitor IC with Coulomb counter/gas gauge, MiniSO-8, STM, RoHS', 'MINISO8' ],

			# TODO: N-pin handling
			// [ 'PIC24HJ64GP502-I/MM 16 bit PIC 40MIPS 64 kB Flash 8 kB RAM 28-Pin QFN-S', 'QFN28-S' ],
			// [ 'Wzmacniacz operacyjny LF411CN/NOPB 4MHz MDIP, 8-Pin', 'MDIP8' ],
			// [ 'Dioda ochronna ESD dwukierunkowa 50V 150W SC70 3-Pin', 'SOT23-3' ],
			// [ 'Wzmacniacz operacyjny TSV522AIYST, 2,7 → 5,5 V 1.15MHz R-R MiniSO, 8-Pin', 'MINISO8' ],
			// [ 'Transoptor, Wyjście tranzystorowe, 1 kanał, DIP, 4 piny/-ów, 60 mA, 5 kV, 100 %', 'DIP4' ],
			// [ 'MCU 32-bit RX RX CISC 256KB Flash 3.3V/5V 64-Pin LQFP', 'LQFP64' ],
			// [ 'MCU 16-bit RL78 CISC 256KB Flash 3.3V/5V 52-Pin LQFP Tray', 'LQFP52' ],

			[ 'AD8353ACPZ IC, AMP, RF\/IF, SMD, LFCSP-8, 8353', 'LFCSP8' ],
			[ 'ADP2503ACPZ-3.3-R7 DC/DC CONV, BUCK-BOOST, 2.5MHZ, LFCSP-10', 'LFCSP10' ],
			[ 'ADXL325BCPZ Small, Low Power, 3-Axis +/-5 g Accelerometer, 16-LFCSP, Analog Devices, RoHS', 'LFCSP16' ],
			[ '24-LFCSP-WQ (4x4)', 'LFCSP24-WQ' ],

			[ '32-LQFP', 'LQFP32' ],
			[ '44-LQFP', 'LQFP44' ],
			[ '48-LQFP', 'LQFP48' ],
			[ '52-LQFP', 'LQFP52' ],
			[ '64-LQFP', 'LQFP64' ],
			[ '80-LQFP', 'LQFP80' ],
			[ '100-LQFP', 'LQFP100' ],
			[ '112-LQFP', 'LQFP112' ],
			[ '120-LQFP', 'LQFP120' ],
			[ '128-LQFP', 'LQFP128' ],
			[ '144-LQFP', 'LQFP144' ],
			[ '176-LQFP', 'LQFP176' ],

			[ '32-VFQFPN (5x5)', 'VFQFPN32' ],
			[ '44-MQFP (10x10)', 'MQFP44' ],

			[ 'S29GL128P11FFIV10 MEMORY, FLASH NOR, 128MBIT, FBGA-64', 'FBGA64' ],
			[ 'SDRAM, DDR3, 128M x 16bit, 1.25 ns, FBGA-96', 'FBGA96' ],
			[ 'XQ7K410T-1RF900I IC FPGA KINTEX-7 900-FBGA', 'FBGA900', ],
			[ 'XQ2VP70-5FF1704N IC FPGA VIRTEX-II PRO 1704-FBGA', 'FBGA1704' ],
			[ 'MPC8360VVAGDGA Microprocessor, MPC8360 Series, 400 MHz, TBGA-191', 'TBGA191' ],
			[ 'Microprocessor, PowerQUICC II Series, 450 MHz, 1.45 V to 1.6 V, TBGA-480', 'TBGA480' ],
			[ 'IC SDRAM 8GBIT 1.067GHZ FBGA', false ],

			[ 'AB-RTCMC-32.768KHZ-AIGZ-S7-T IC RTC CLK/CALENDAR I2C 8-CLCC', 'CLCC8' ],
			[ 'CY25701FLXCT IC OSC XTAL PROG 4-CLCC', 'CLCC4' ],
			[ 'DS4100H Timer, Oscillator & Pulse Generator IC, Low Jitter HCSL, 100 MHz, 3.135 V to 3.465 V, LCCC-10', 'LCCC10' ],
			[ 'DAC7725 PLCC-28', 'PLCC28' ],

			// DigiKey normalization
			[ '8-SON (A) (2.9x2.8)', 'SON8' ],
			[ '6-SON (1.45x1)', 'SON6' ],
			[ '6-XSON, SOT886 (1.45x1)', 'XSON6' ],
			[ '8-XSON, SOT996-2 (2x3)', 'XSON8' ],
			[ '10-WSON (3x3)', 'WSON10' ],
			[ '10-VSON (3x3)', 'VSON10' ],
			[ '4-X2SON (1x1)', 'X2SON4' ],
			[ 'PG-TDSON-8', 'PGTDSON-8' ],

			[ 'DO-200AA, R62', 'DO-200AA' ],
			[ 'DO-200AB, B-PUK', 'DO-200AB' ],
			[ 'DO-205AB, DO-9', 'DO-205AB' ],
			[ 'DO-213AB (MELF, LL41)', 'DO-213AB' ],
			[ 'DO-214AB, (SMC)', 'DO-214AB' ],

			[ 'Tranzystor P-MOSFET 55V 18A DPAK TO-252', 'TO-252' ],
			[ 'TO-252, (D-Pak)', 'TO-252' ],
			[ 'D-Pak', 'TO-252' ],
			[ 'DPAK', 'TO-252' ],
			[ 'IRL3803S smd * Liczba w opakowaniu:50 * Liczba w opakowaniu:100 * Obudowa:TO263 (D2PAK) * Obudowa:TO263t/r (D2PAK)', 'TO-263' ],
			[ 'Liniowy stabilizator napięcia, 7808, stały, wejście 35V, wyjście 8V i 0.5A, TO-252-3', 'TO-252-3' ],
			[ 'Liniowy stabilizator TO-252-4', false ],
			[ 'Stabilizator napięcia LDO, stały, wejście 5.5 V do 42 V, drop 250 mV, wyjście 5 V i 450 mA, TO-252-5', 'TO-252-5' ],
			[ 'MOSFET P-kanałowy IRFR5505TRPBF 55 V 18 A 3-Pin TO-252AA SMD', 'TO-252' ],
			[ 'CSD19506KTT MOSFET N-CH 80V 200A DDPAK-3', 'TO-263' ],
			[ 'Stabilizator napięcia LDO LM1085IS-5.0/NOPB 3A 5 V 2,6 → 25 Vin TO-263 3-Pin', 'TO-263' ],
			[ 'IC REG LDO 5V 0.15A DDPAK', 'TO-263' ],
			[ 'DIODE, 10A, 50V, TO-263AB', 'TO-263AB' ],
			[ 'STEP-DOWN REGULATOR, TO-263-5', 'TO-263-5' ],

			[ 'MOSFET P-kanałowy IRF4905LPBF 55 V 74 A 3-Pin TO-262', 'TO-262' ],
			[ 'DIODE SCHOTTKY 10A 60V TO-262AA', 'TO-262AA' ],

			[ 'MOSFET N-CH 1000V 20A TO-268', 'TO-268' ],

			[ 'DIODE SCHOTTKY 200V 10A TO277', 'TO-277' ],
			[ 'Schottky Diodes & Rectifiers 100V 8A Single Die SMPC (TO-277A)', 'TO-277A' ],
			[ 'AU2PJHM3_A/I Rectifiers 2A,600V, SMPC,FER, Avalanche SM', 'TO-277A' ],

			// TO-202, 3-Lead Through-Hole, with Metal Tab
			[ 'X0403BE TO202-1', 'TO-202-1' ],
			[ 'MPS9805* TO202-1 NPN 65V 0.1A 0.5W =BC107', 'TO-202-1' ],
			[ 'X0403DF ST 96+ TO202-3', 'TO-202-3' ],

			// https://en.wikipedia.org/wiki/Small_Outline_Diode
			[ 'Dioda prostownicza SMD standardowa 1000V 1A obudowa SOD-123FL', 'SOD123FL'],
			[ '0603/SOD-523F', 'SOD523F' ],
			[ '1005/SOD-323F', 'SOD323F' ],
			[ 'SOD323F (SC-90)', 'SOD323F' ],
			[ 'BAS21J Dioda przełączająca BAS21J, 2-Pin, SMD, 300V, 250mA, SC-90' , 'SOD323F' ],

			[ 'PWM CONTROLLER, 1KHZ, 26.5V, UMAX-8', 'UMAX8' ],
			[ 'MAX5703AUB DAC, 8BIT, UMAX-10', 'UMAX10' ],
			[ 'IC POT NV 128POS HV 10-USOP', 'USOP10' ],
			[ 'DS1080LU CLOCK GENERATOR, 134MHZ, USOP-8', 'USOP8' ],

			[ 'IC SUPERVISOR 1.8V USP-3', 'USP3' ],
			[ 'IC REG LDO 2.85V 0.2A USP4', 'USP4' ],
			[ '4-USP (1.2x1.6)', 'USP4' ],
			[ 'IC REG BUCK 1.5V 0.6A SYNC USP-6', 'USP6' ],
			[ 'IC VOLT DET TIME DLY 2.5V 4-USPN', 'USPN4' ],
			[ 'IC REG LDO 2.5V 0.3A USPQ-4B03', 'USPQ4B03' ],
			[ 'IC REG BST ADJ 1.2A SYNC USP10B', 'USP10B' ],

			[ 'PMR290UNE N-channel enhancement mode Field-Effect Transistor (FET) in a small SOT416 (SC-75) Surface-Mounted Device (SMD) plastic package using Trench MOSFET', 'SOT416' ],
			[ 'DAN222T1G Dioda DAN222G 100mA 80V 4ns SOT-416 3-Pin', 'SOT416' ],
			[ 'TRANS PREBIAS NPN 150MW SOT523', 'SOT416' ],
			[ '2SA2018TL Tranzystor bipolarny PNP 12 V 500 mA 100 MHz HFE 270 SC-75A 2SA2018TL 3-Pin' ,'SOT416' ],
			[ 'BC847BTT1G BIPOLAR TRANSISTOR, NPN, 45V, SC-75', 'SOT416' ],
			[ '2SD2654TLW Tranzystor bipolarny NPN 50 V 150 mA 100 MHz HFE 820 SC-75A 2SD2654TLW 3-Pin', 'SOT416' ],

			[ 'MOSFET N-kanałowy podwójny EM6K7T2R 20 V 200 mA 6-Pin SOT-563 SMD', 'SOT563' ],
			[ 'MOSFET N-kanałowy podwójny 2N7002PV 60 V 350 mA 6-Pin SOT-666 SMD', 'SOT666' ],

			[ 'rezystor 390k 1% 0207 MMB 0207-50 B2 MELF', 'MELF' ],
			[ 'rezystor 390k 1% 0207 MMB', 'MELF' ],
			[ 'DIODE ZENER 4.7V 1W MELF', 'MELF' ],
			[ 'DIODE GEN 50V 600MA MINI MELF', 'MiniMELF' ],
			[ 'Rezystor MELF montowany powierzchniowo, 68 ohm, 200 V, 400 mW, ± 1%, MMA 0204', 'MELF' ], # TODO: MMA -> MiniMELF
			[ 'Rezystor seria MMA 0204', 'MiniMELF' ],
			[ 'Rezystor montowany powierzchniowo, seria MMU 0102, 680 ohm, 100 V, 200 mW, ± 1%', 'MicroMELF' ],
			[ 'DIODA ZENERA 5,6V 0,5W PHILIPS BZV55 BZV55C5V6 SMD 0204 SOD80C MiniMELF', 'MiniMELF' ],
			[ 'Seria MMU 0102 RES, MELF, 120R, 1%, 200MW, SMD', 'MicroMELF' ],
			[ 'Seria MMU 0102 RES, SMD', 'MicroMELF' ],
			[ 'Rezystor SMD 510K 0102 1% MICRO-MELF', 'MicroMELF' ],

			[ 'Pojedyncza dioda Zenera, 6.2 V, 500 mW, DO-204AA, 2 piny/-ów, 200 °C', 'DO-7' ],
			[ 'NTE6155 STANDARD DIODE, 150A, 400V, DO-8', 'DO-8' ],
			[ 'Dioda prostownicza 1000V/1,5A Obudowa: DO-15 Temperatura: -55/+150°C', 'DO-15' ],
			[ 'Rectifier, 50V 1A, 2-Pin DO-41', 'DO-41' ],
			[ 'DIODE SCHOTTKY 1A 30V DO220AA', 'DO-220AA' ],
			[ '1N5408 - Dioda prostownicza 3A 1000V DO201AD', 'DO-201AD' ],
			[ '1.5KE6V8 TVS BIDIRECTIONAL 6.8V 1500W CB429 (DO-201AD) 1.5KE6V8CA', 'DO-201AD' ],
			[ 'ST MICROELECTRONICS 1.5KE24CA Dioda: transil; 1,5kW; 24V; 45A; dwukierunkowa; CB429', 'DO-201AD' ],
			[ '1N5408 Dioda prostownicza 1000V/3A Obudowa: DO-27 = DO-201AD Temperatura: -55/+150°C', 'DO-27' ],
			[ 'Dioda:  prostownicza, SMD, 2kV, 2A, Opakowanie:  taśma, DO214AA', 'DO-214AA' ],

			[ 'BA-4908 SILP-12 UKŁAD', 'SILP12' ],
			[ 'LA-7830=LA-7832 SILP-7 UKŁAD', 'SILP7' ],
			[ 'LA-4280= ( BRAK ) 2x AF- OS 32V 4A 2X10W (32V/ 8Ohm ) ( 14- SILP )', 'SILP14' ],
			[ 'TDA-1562-Q SILP-16 UKŁAD', 'SILP16' ],
			[ 'LA-5609 SILP-18 UKŁAD', 'SILP18' ],
			[ 'TDA1562Q Układ scalony wzmacniacz mocy 70W 4R SIL17', 'SIL17' ],
			[ 'TDA-8947-J SIL-17 UKŁAD', 'SIL17' ],
			[ 'UKŁAD SCALONY TDA4601 SIL9 SIEMENS', 'SIL9' ],

			[ 'TDA 4601 SIP9 ORG.-SIEMENS', 'SIP9' ],
			[ '2SA798 PRODUCENT / MANUFACTURER: MIT OBUDOWA / PACKAGE: SIP-5 5-PIN P SUPERVISORY CIRCUIT', 'SIP5' ],

			// ZIP - http://www.interfacebus.com/ic-package-zig-zag-drawing.html
			[ 'układ TC514256Z-10 DRAM 256kx4 ZIP-20 TOSHIBA', 'ZIP20' ],
			[ 'układ M5M4C256L12 ZIP-24 DRAM 64Kx4 MITSUBISHI', 'ZIP24' ],
			[ 'TDA6101Q ZIP-9 PHI L=22', 'ZIP9' ],
			[ 'STR5412 * Liczba w opakowaniu:25 * Obudowa:ZIP-5', 'ZIP5' ],
			[ 'układ M5M41000AL10 DRAM 1Mx1 ZIP-20 MITSUBISHI', 'ZIP20' ],
			[ 'UKŁAD SCALONY AN8028 ZIP-9 PIN', 'ZIP9' ],
			[ 'L2724-W99EM0049 Encapsulation:ZIP-9,Lowdrop Dual Power OP AMP IC NEW', 'ZIP9' ],
			[ 'STR5412 * Liczba w opakowaniu:25 * Obudowa:ZIP-5', 'ZIP5' ],
			[ 'TDA7376B PRODUCENT / MANUFACTURER: ST OBUDOWA / PACKAGE: ZIP15 POWER AMPLIFIER FOR CAR RADIO2×35W', 'ZIP15' ],
			[ 'TDA7378 ZIP 15,DUAL BRIDGE AUDIO AMPLIFIER', 'ZIP15' ],

			// Pentawatt
			[ 'VIPER50A-E STM Current Mode Controller 700V 1.5A  PENTAWATT VIPER50A', 'PENTAWATT' ],
			[ 'VIPER20 PENTAWATT HV 5PIN VIPER20A', 'PENTAWATT' ],
			[ 'Liniowy regulator napięcia L200CV 2A Z regulacją 2,85 → 36 V, 5-Pin PENTAWATT', 'PENTAWATT' ],
			[ 'VIPER100 PENTAWATT HV 5PIN 100W SMART HV5 620V 3A', 'PENTAWATT' ],
			[ 'Tranzystor: N-MOSFET; unipolarny; 500V; 8A; 125W; TO220-5', 'PENTAWATT' ],
			[ 'TDA2030A SUM * Liczba w opakowaniu:50 * Obudowa:PENTAWATT-V', 'PENTAWATT-V' ],

			// SQL
			[ 'STR59041 SQL5 układ scalony', 'SQL5' ],
			[ 'STRF 6656 SQL-5', 'SQL5' ],
			[ 'TA8200AH SQL12 układ scalony', 'SQL12' ],
			[ 'TDA8944J SQL17', 'SQL17' ],

			// no package data
			[ 'Tranzystor: NPN; STO39; bipolarny; 75V; 500mA; 800mW', false ],
			[ 'Tranzystor: NPN; TO3954; bipolarny; 75V; 500mA; 800mW', false ],
			[ 'Tranzystor: NPN; TO39A; bipolarny; 75V; 500mA; 800mW', false ],
			[ 'Tranzystor: NPN; DIP220; bipolarny; 75V; 500mA; 800mW', false ],

			// igbt-power normalization
			// [ 'TO-261-4', '-' ],
			// [ 'TO-226-3', '-' ],
			[ 'TO-126', 'TO-126' ],
			[ '16-SOIC', 'SOIC16' ],
			[ '16-TSSOP', 'TSSOP16' ],
			[ '144-LQFP', 'LQFP144' ],
			[ '64-LQFP', 'LQFP64' ],
			// https://github.com/elecena/ic-package-info/issues/58
			[ 'IC BUF NON-INVERT 5.25V SOIC14', 'SOIC14' ],
			[ 'IC BUF NON-INVERT 5.25V 14SOIC', 'SOIC14' ],

			// normalize packages
			[ '64-LQFP (10x10)', 'LQFP64' ], // https://elecena.pl/product/7840023/atsam3n1bb-aur (DigiKey)
			[ '28-QFN (6x6)', 'QFN28' ],
			[ '20-TSSOP', 'TSSOP20' ],
			[ '144-LQFP (20x20)', 'LQFP144' ],
			[ '10-MLF® (3x3)', 'MLF10' ],
			[ 'NIS5135MN1TXG Kontroler Hot Swap, zasilanie 3.1V do 18V, DFN-10', 'DFN10' ],
			[ 'TO-263AB (D²PAK)', 'TO-263AB' ],
			[ 'D²PAK (TO-263AB)', 'TO-263AB' ],
			// [ 'NCP103AMX105TCG Stabilizator napięcia LDO, stały, wejście 1.7V do -5.5V, wyjście 1.05Vnom / 150mA, µDFN-4', 'µDFN4' ], # TODO

			// https://en.wikipedia.org/wiki/DO-204
			[ 'DO-204AL (DO-41)', 'DO-41' ],
			[ 'DO-35 (DO-204AH)', 'DO-35' ],
			[ 'DO-7 (DO-204AA)', 'DO-7' ], // https://elecena.pl/product/6710195/1n747a (Digi-Key)

			[ 'DO-204AA', 'DO-7' ],
			[ 'DO-204AH', 'DO-35' ],
			[ 'SOD27', 'DO-35' ],
			[ 'DO-204AL', 'DO-41' ],
			[ 'SOD66', 'DO-41' ],

			// Analog Devices
			[ '24 ld QFN (4x4mm w/2.8mm ep)', 'QFN24' ],
			[ '80 ld LQFP (12x12x1.4mm)', 'LQFP80' ],

			// triacs
			[ 'Triak BTA 40/600B Imax = 40A Umax = 600V obudowa: RD91', 'RD91' ],
			[ 'BTA40-600B - STMICROELECTRONICS - Triak, 600 V, 40 A, RD-91, 50 mA, 1.5 V, 1 W', 'RD91' ],

			// ISO packages
			[ 'BU2508D INCH 0410 ISO218', 'ISO218' ],
		];
	}
}
