<?php
// This file is part of BOINC.
// http://boinc.berkeley.edu
// Copyright (C) 2014 University of California
//
// BOINC is free software; you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License
// as published by the Free Software Foundation,
// either version 3 of the License, or (at your option) any later version.
//
// BOINC is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with BOINC.  If not, see <http://www.gnu.org/licenses/>.

// concierge is a mechanism for downloading an installer
// pre-configured for a particular project or AM account
//
// This script gets (via POST)
//  - ID of a project or AM
//  - optional login token
//  - the name of an installer file
// Action:
// - look up the ID
// - start a download of the requested installer,
//   with a filename that encodes the ID and login token
//

$dir = getcwd();
chdir("../projects/dev/html/user");
require_once("../inc/util.inc");
chdir($dir);
require_once("versions.inc");
require_once("projects.inc");
require_once("concierge.inc");

$master_url = urldecode(post_str("master_url"));

// check if URL is in vetted list
//
$vp = vps_lookup($master_url);
if (!$vp) {
    echo "URL $master_url not found";
    exit;
}

$auth = post_str("auth", true);
if ($auth) $auth = urldecode($auth);

$user_name = post_str("user_name", true);
if ($user_name) $user_name = urldecode($user_name);

$filename = post_str("filename");

$download_url = "https://boinc.berkeley.edu/dl/$filename";

// add info to filename.
// We should keep the filename as short as possible;
// long filenames are unexpected and might scare people off.
// So add only the basics:
// - entity URL
// - whether it's an AM
// - account user name and account token
//
// Would be nice to include other stuff (entity institution/description)
// to show on the welcome screen.
// Can get that by other means (e.g. get_config RPC)

$info = sprintf("p=%d&am=%d",
    $master_url,
    $vp->is_am?1:0
);

if ($auth && $user_name) {
    $info .= sprintf("&ut=%s&un=%s",
        $auth,
        $user_name
    );
}

$filename .= '__'.base64_encode($info);
echo "url: $download_url  file: $filename\n"; exit;
header("Location: ".$download_url);
header(sprintf('Content-Disposition: attachment; filename="%s"', $filename));

?>
