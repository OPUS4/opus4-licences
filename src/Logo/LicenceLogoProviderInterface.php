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

namespace Opus\Licences\Logo;

use Opus\Licence;

/**
 * Interface for auto-downloading and serving license logo files.
 */
interface LicenceLogoProviderInterface
{
    /**
     * Returns the path to a directory that stores licence logo files, or null if no such
     * directory has been defined.
     *
     * @return string|null
     */
    public function getLicenceLogosDir();

    /**
     * Sets the path to a directory that stores licence logo files.
     *
     * @param string $licenceLogosDir
     */
    public function setLicenceLogosDir($licenceLogosDir);

    /**
     * Returns the URL of a remotely available licence logo that represents the given licence.
     *
     * @param Licence $licence
     * @return string|null Licence logo URL.
     */
    public function getLicenceLogoUrl($licence);

    /**
     * Returns the file name (or path relative to the licence logos directory) of a licence logo that
     * represents the given licence.
     *
     * @param Licence $licence
     * @return string|null Licence logo name or path relative to licence logos directory.
     */
    public function getLicenceLogoName($licence);

    /**
     * Returns the absolute path to the local licence logo file to be used for the given licence.
     *
     * @param Licence $licence
     * @return string|null Absolute path to local licence logo file.
     */
    public function getLicenceLogoPath($licence);
}
