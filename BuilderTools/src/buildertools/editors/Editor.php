<?php

/**
 * Copyright 2018 CzechPMDevs
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace buildertools\editors;

use buildertools\BuilderTools;

/**
 * Class Editor
 * @package buildertools\editors
 */
abstract class Editor {

    const CANCELLER = "Canceller";
    const COPIER = "Copier";
    const DECORATOR = "Decorator";
    const FILLER = "Filler";
    const FIXER = "Fixer";
    const NATURALIZER = "Naturalizer";
    const PRINTER = "Printer";
    const REPLACEMENT = "Replacement";

    /**
     * @return string
     */
    abstract function getName():string;

    /**
     * @return BuilderTools
     */
    public function getPlugin():BuilderTools {
        return BuilderTools::getInstance();
    }
}