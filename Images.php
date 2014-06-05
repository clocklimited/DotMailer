<?php
require_once("DotMailer.php");
/**
* Description
*
* @version 1.0
* @author Clock Ltd
* @copyright Clock Limited 2012
* @license http://opensource.org/licenses/bsd-license.php New BSD License
*/
class Images extends DotMailer {

	/**
	 * Returns the tree of folders available to upload images to in your account.
	 *
	 * @link http://www.dotmailer.co.uk/api/images/get_image_folders.aspx
	 * @return Array containing folder details
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function getImageFolders() {
		$params = array();
		return $this->send("getImageFolders", $params);
	}

	/**
	 * Creates a new folder in which to store images.
	 *
	 * @link http://www.dotmailer.co.uk/api/images/create_image_folder.aspx
	 * @param name String The name for your new image folder.
	 * @param parentFolderId Integer This is the identifier of the parent folder in which this new folder
	 *		should be created. The root folder has the ID of 0 (zero).
	 * @return Array containing the newly created image folder tree
	 * @throws ImageParentFolderDoesNotExistException
	 * @throws ImageParentFolderDeletedException
	 * @throws ImageNameInvalidException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function createImageFolder($name, $parentFolderId) {
		$params = array();
		$params["name"] = $name;
		$params["parentFolderId"] = $parentFolderId;
		return $this->send("createImageFolder", $params);
	}

	/**
	 * Uploads a new image for use in campaigns to a specified folder.
	 *
	 * @link http://www.dotmailer.co.uk/api/images/upload_image.aspx
	 * @param Integer This is the identifier of the parent folder in which this new image should be created.
	 *		The root folder has the ID of 0 (zero).
	 * @param fileName String The filename for your new image.
	 * @param currentLocation The location of the file on your file system.
	 * @return Array containing the image id and path.
	 * @throws ImageParentFolderDoesNotExistException
	 * @throws ImageParentFolderDeletedException
	 * @throws ImageNameInvalidException
	 * @throws ImageUnsupportedFormatException
	 * @throws ImageDataEmptyException
	 * @throws ApiUsageExceededException
	 * @throws InvalidLoginException
	 * @throws SystemServiceTemporarilyUnavailaleException
	 * @throws UnknownException
	 */
	public function uploadImage($parentFolderId, $fileName, $currentLocation) {
		$params = array();
		$params["parentFolderId"] = $parentFolderId;
		$params["fileName"] = $fileName;
		$fileData = "";
		if (is_readable($currentLocation)) {
			$fileData = file_get_contents($currentLocation);
			base64_encode($fileData);
		}
		$params["imageData"] = $fileData;
		return $this->send("uploadImage", $params);
	}
}