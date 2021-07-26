<?php

namespace MantraLibrary\Model;

/**
 * Have all the default options
 * 
 * @see DEFAULT_SDL_CLOUD_PRO_URL - Must have from the user
 * @author iflorian
 *
 */
class ConfigModel
{

    const DEFAULT_SDL_CLOUD_PRO_URL = 'https://languagecloud.sdl.com';

    const DEFAULT_GRANT_TYPE = 'password';

    const AUTH_TOKEN_URI = 'tm4lc/api/v1/auth/token';

    const PROJECT_CREATION_OPTIONS_URI = 'tm4lc/api/v1/projects/options';

    const FILE_UPLOAD_URI = 'tm4lc/api/v1/files/{projectOptionsId}';

    const UPLOADED_FILE_URI = 'tm4lc/api/v1/files/{projectOptionsId}';

    const CREATE_PROJECT_URI = '/tm4lc/api/v1/projects';

    const APPROVE_PROJECT_URI = '/tm4lc/api/v1/projects/{projectId}';

    const PROJECT_STATUS_URI = '/tm4lc/api/v1/projects/{projectId}';

    const DOWNLOAD_FILE_URI = '/tm4lc/api/v1/files/{projectId}/{fileId}';

    const PROJECT_QUOTE_URI = '/tm4lc/api/v1/projects/{projectId}/quote/{format}';

    const PROJECTS_LIST_URI = 'tm4lc/api/v1/projects';

    const CANCEL_PROJECT_URI = '/tm4lc/api/v1/projects/{projectId}';

    const DOWNLOAD_TARGET_ZIP_URI = '/tm4lc/api/v1/projects/{projectId}/zip?types=TargetFiles';
}