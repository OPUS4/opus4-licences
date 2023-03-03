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

use Opus\Common\Config;
use Opus\Licence;

use function file_exists;
use function file_put_contents;
use function parse_url;
use function substr;

use const DIRECTORY_SEPARATOR;
use const PHP_URL_PATH;

/**
 * Provides a license logo file for a given license and optionally auto-downloads the logo files.
 */
class LicenceLogoProvider implements LicenceLogoProviderInterface
{
    /** @var string Path to a directory that stores licence logo files */
    private $licenceLogosDir = "";

    /**
     * Returns the path to a directory that stores licence logo files, or null if no such
     * directory has been defined.
     *
     * @return string|null
     */
    public function getLicenceLogosDir()
    {
        $licenceLogosDir = $this->licenceLogosDir;

        if (empty($licenceLogosDir)) {
            $config = Config::get();

            if (isset($config->licenses->logos->path)) {
                $licenceLogosDir = $config->licenses->logos->path;
            }

            if (empty($licenceLogosDir)) {
                return null;
            }
        }

        if (substr($licenceLogosDir, -1) !== DIRECTORY_SEPARATOR) {
            $licenceLogosDir .= DIRECTORY_SEPARATOR;
        }

        return $licenceLogosDir;
    }

    /**
     * Sets the path to a directory that stores licence logo files.
     *
     * @param string $licenceLogosDir
     */
    public function setLicenceLogosDir($licenceLogosDir)
    {
        $this->licenceLogosDir = $licenceLogosDir;
    }

    /**
     * Returns the URL of a remotely available licence logo that represents the given licence.
     *
     * @param Licence $licence
     * @return string|null Licence logo URL.
     */
    public function getLicenceLogoUrl($licence)
    {
        $licenceLogoUrl = $licence->getLinkLogo();
        if (empty($licenceLogoUrl)) {
            return null;
        }

        return $licenceLogoUrl;
    }

    /**
     * Returns the file name (or path relative to the licence logos directory) of a licence logo that
     * represents the given licence.
     *
     * @param Licence $licence
     * @return string|null Licence logo name or path relative to licence logos directory.
     */
    public function getLicenceLogoName($licence)
    {
        $licenceLogoUrl = $this->getLicenceLogoUrl($licence);
        if (empty($licenceLogoUrl)) {
            return null;
        }

        $urlPath = parse_url($licenceLogoUrl, PHP_URL_PATH);
        if (empty($urlPath)) {
            return null;
        }

        // remove any preceding path separator
        if (substr($urlPath, 0, 1) === DIRECTORY_SEPARATOR) {
            $urlPath = substr($urlPath, 1);
        }

        return $urlPath;
    }

    /**
     * Returns the absolute path to the local licence logo file to be used for the given licence.
     *
     * @param Licence $licence
     * @return string|null Absolute path to local licence logo file.
     */
    public function getLicenceLogoPath($licence)
    {
        $licenceLogosDir = $this->getLicenceLogosDir();
        if (empty($licenceLogosDir)) {
            return null;
        }

        $licenceLogoName = $this->getLicenceLogoName($licence);
        if (empty($licenceLogoName)) {
            return null;
        }

        $licenceLogoPath = $licenceLogosDir . $licenceLogoName;

        if (! $this->cachedLicenceLogoExists($licenceLogoPath)) {
            // auto-download logo file if it doesn't exist locally
            $logoData = $this->downloadLicenceLogo($licence);
            if (empty($logoData)) {
                return null;
            }

            $savedSuccessfully = $this->saveLogoData($logoData, $licenceLogoPath);
            if (! $savedSuccessfully) {
                return null;
            }
        }

        return $licenceLogoPath;
    }

    /**
     * Returns true if a licence logo file exists locally at the given file path, otherwise returns false.
     *
     * @param string $filePath Absolute path to local licence logo file.
     * @return bool
     */
    protected function cachedLicenceLogoExists($filePath)
    {
        if (! file_exists($filePath)) {
            return false;
        }

        return true;
    }

    /**
     * Downloads a licence logo file matching the given licence and returns its file data, or null if an
     * error occurred.
     *
     * @param Licence $licence
     * @return string|null
     */
    protected function downloadLicenceLogo($licence)
    {
        $licenceLogoUrl = $this->getLicenceLogoUrl($licence);
        if (empty($licenceLogoUrl)) {
            return null;
        }

        // TODO: implement download functionality
        // TODO: ensure a reasonable timeout for the download functionality

        return null;
    }

    /**
     * Saves the given logo file data at the given path. Returns true if storage was successful,
     * otherwise returns false.
     *
     * @param string $logoData Logo file data to be stored at the given path.
     * @param string $logoPath Path at which the given logo file data shall be stored.
     * @return bool
     */
    protected function saveLogoData($logoData, $logoPath)
    {
        $result = file_put_contents($logoPath, $logoData);

        return ! ($result === false);
    }
}
