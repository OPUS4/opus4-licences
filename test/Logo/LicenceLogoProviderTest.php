<?php

/**
 * This file is part of OPUS. The software OPUS has been originally developed
 * at the University of Stuttgart with funding from the German Research Net,
 * the Federal Department of Higher Education and Research and the Ministry
 * of Science, Research and the Arts of the State of Baden-Wuerttemberg.
 *
 * OPUS 4 is a complete rewrite of the original OPUS software and was developed
 * by the Stuttgart University Library, the Library Service Center
 * Baden-Wuerttemberg, the Cooperative Library Network Berlin-Brandenburg,
 * the Saarland University and State Library, the Saxon State Library -
 * Dresden State and University Library, the Bielefeld University Library and
 * the University Library of Hamburg University of Technology with funding from
 * the German Research Foundation and the European Regional Development Fund.
 *
 * LICENCE
 * OPUS is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the Licence, or any later version.
 * OPUS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details. You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @copyright   Copyright (c) 2023, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 */

namespace OpusTest\Licences\Logo;

use Opus\Licence;
use Opus\Licences\Logo\LicenceLogoProvider;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

class LicenceLogoProviderTest extends TestCase
{
    public function testGetLicenceLogoPath()
    {
        $licenceLogoProvider = new LicenceLogoProvider();
        $licenceLogoProvider->setLicenceLogosDir($this->getLicenceLogosDir());

        $licence1         = $this->getSampleLicenceCCBYNCND();
        $licenceLogoPath1 = $licenceLogoProvider->getLicenceLogoPath($licence1);

        $this->assertNotNull($licenceLogoPath1);
        $this->assertFileExists($licenceLogoPath1);

        $licence2         = $this->getSampleLicenceCCBYSA();
        $licenceLogoPath2 = $licenceLogoProvider->getLicenceLogoPath($licence2);

        $this->assertNotNull($licenceLogoPath2);
        $this->assertFileExists($licenceLogoPath2);
    }

    /**
     * Returns the absolute path to a fixture directory containing licence logo files.
     *
     * @return string
     */
    private function getLicenceLogosDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'licences';
    }

    /**
     * Returns a sample Licence object representing a 'CC BY-NC-ND 4.0' Creative Commons licence.
     *
     * @return Licence
     */
    private function getSampleLicenceCCBYNCND()
    {
        $licence = new Licence();
        $licence = $licence->fetchByName('CC BY-NC-ND 4.0');
        if ($licence === null) {
            $licence = new Licence();
            $licence->setName('CC BY-NC-ND 4.0');
            $licence->setNameLong('CC BY-NC-ND (Attribution – NonCommercial – NoDerivatives)');
            $licence->setLinkLicence('https://creativecommons.org/licenses/by-nc-nd/4.0');
            $licence->setLinkLogo('https://licensebuttons.net/l/by-nc-nd/4.0/88x31.png');
            $licence->setLanguage('eng');
            $licence->store();
        }

        return $licence;
    }

    /**
     * Returns a sample Licence object representing a 'CC BY-SA 4.0' Creative Commons licence.
     *
     * @return Licence
     */
    private function getSampleLicenceCCBYSA()
    {
        $licence = new Licence();
        $licence = $licence->fetchByName('CC BY-SA 4.0');
        if ($licence === null) {
            $licence = new Licence();
            $licence->setName('CC BY-SA 4.0');
            $licence->setNameLong('CC BY-SA (Attribution – ShareAlike)');
            $licence->setLinkLicence('https://creativecommons.org/licenses/by-sa/4.0');
            $licence->setLinkLogo('https://licensebuttons.net/l/by-sa/4.0/88x31.png');
            $licence->setLanguage('eng');
            $licence->store();
        }

        return $licence;
    }
}
