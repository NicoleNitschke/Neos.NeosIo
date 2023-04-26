<?php
declare(strict_types=1);

namespace Neos\MarketPlace\Service;

/*
 * This file is part of the Neos.MarketPlace package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Package Version Utility
 *
 * @Flow\Scope("singleton")
 * @api
 */
class PackageVersion
{
    /**
     * @param NodeInterface $node
     * @return array
     * @throws \Neos\Eel\Exception
     */
    public function extractVersions(NodeInterface $node): array
    {
        $query = new FlowQuery([$node]);
        return $query
            ->find('versions')
            ->find('[instanceof Neos.MarketPlace:Version]')
            ->get();
    }

    /**
     * @param NodeInterface $node
     * @return NodeInterface
     * @throws \Neos\ContentRepository\Exception\NodeException
     * @throws \Neos\Eel\Exception
     */
    public function extractLastVersion(NodeInterface $node): ?NodeInterface
    {
        $versions = $this->extractVersions($node);
        usort($versions, static function (NodeInterface $a, NodeInterface $b) {
            return $b->getProperty('versionNormalized') <=> $a->getProperty('versionNormalized');
        });
        $stableVersions = array_filter($versions, static function (NodeInterface $version) {
            return $version->getProperty('stability') === true;
        });
        if (count($stableVersions) > 0) {
            $version = reset($stableVersions);
        } else {
            $version = reset($versions);
        }

        return $version ?: null;
    }
}
