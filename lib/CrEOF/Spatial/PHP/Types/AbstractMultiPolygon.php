<?php
/**
 * Copyright (C) 2012 Walter Dal Mut
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace CrEOF\Spatial\PHP\Types;

use CrEOF\Spatial\PHP\Types\AbstractGeometry;

abstract class AbstractMultiPolygon extends AbstractGeometry
{
    protected $polygons = array();

    public function __construct(array $polygons, $srid = null)
    {
        $this->setPolygons($polygons)
            ->setSrid($srid);
    }

    public function setPolygons($polygons)
    {
        $this->polygons = $polygons;
        return $this;
    }

    public function addPolygon($polygon)
    {
        $this->polygon[] = $this->validatePolygonValue($polygon->getRings());

        return $this;
    }

    public function getMultiPolygons()
    {
        $polygons = array();

        for ($i=0; $i<count($this->polygons); $i++) {
            $polygons[] = $this->getPolygon($i);
        }
    }

    public function getPolygon($index)
    {
        if ($index == -1) {
            $index = count($this->polygons) - 1;
        }

        $polygonClass = $this->getNamespace() . "\Polygon";

        return new $polygonClass($this->polygons[$index], $this->srid);
    }

    public function getType()
    {
        return self::MULTIPOLYGON;
    }

    public function toArray()
    {
        return $this->polygons;
    }
}
