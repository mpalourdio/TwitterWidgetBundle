<?php
/*
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace TwitterWidgetBundleTests\Extension;

use PHPUnit\Framework\TestCase;
use TwitterWidgetBundle\Extension\TimelineWidget;
use TwitterWidgets\Options\WidgetOptions;
use TwitterWidgets\Timeline\TimelineBuilder;

class TimelineWidgetTest extends TestCase
{
    public function testInstance()
    {
        $widgetOptions   = $this->createMock(WidgetOptions::class);
        $timelineBuilder = new TimelineBuilder($widgetOptions);

        $this->assertInstanceOf(TimelineWidget::class, new TimelineWidget($widgetOptions, $timelineBuilder));
    }

    public function testTwoFunctionsAreRegistered()
    {
        $widgetOptions   = $this->createMock(WidgetOptions::class);
        $timelineBuilder = new TimelineBuilder($widgetOptions);

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertCount(2, $extension->getFunctions());
    }

    public function testName()
    {
        $widgetOptions   = $this->createMock(WidgetOptions::class);
        $timelineBuilder = new TimelineBuilder($widgetOptions);

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertEquals('timelinewidgetextensions', $extension->getName());
    }

    public function testOneTimeJs()
    {
        $widgetOptions   = $this->createMock(WidgetOptions::class);
        $timelineBuilder = new TimelineBuilder($widgetOptions);

        $extension = new TimelineWidget($widgetOptions, $timelineBuilder);

        $this->assertGreaterThan(0, strpos($extension->getOneTimeWidgetJs(), 'widgets.js'));
    }


    public function testRenderWidget()
    {
        $widgetOptions = $this->createMock(WidgetOptions::class);

        $timelinebuilder = $this
            ->getMockBuilder(TimelineBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $timelinebuilder->expects($this->any())
            ->method('renderWidget')
            ->will($this->returnValue('rendered!'));

        $extension = new TimelineWidget($widgetOptions, $timelinebuilder);

        $this->assertEquals('rendered!', $extension->renderWidget([]));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongTypeThrowsException()
    {
        $widgetOption = $this
            ->getMockBuilder(WidgetOptions::class)
            ->disableOriginalConstructor()
            ->getMock();

        $timelineBuilder = $this
            ->getMockBuilder(TimelineBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $viewHelper = new TimelineWidget($widgetOption, $timelineBuilder);
        $options    = new \stdClass();

        $viewHelper->renderWidget($options);
    }
}
