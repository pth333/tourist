<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\DestinationFoodDetail;
use App\Models\Tour;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\QueryCommonData;

class DialogflowController extends Controller
{
    use QueryCommonData;
    public function handleWebhook(Request $request)
    {
        $action = $request->input('queryResult.action');
        Log::info($action);
        switch ($action) {
            case 'destination.action';
                return $this->handleDestination($request);
            case 'address.action';
                return $this->handleAddress($request);
            case 'view.action';
                return $this->handleViewDes($request);
            case 'activities_des.action';
                return $this->handleActivityDes($request);
            case 'food.action';
                return $this->handleFoodDes($request);
            case 'image_des.action';
                return $this->handleImageDes($request);
            case 'video_des.action';
                return $this->handleVideoDes($request);
            case 'ticketprice.action';
                return $this->handleTicketPrice($request);
            case 'freefollowdes.action';
                return $this->handleFreeFollowDes($request);
            case 'pricedestination.action';
                return $this->handlePriceDestination($request);
            case 'typedestination.action';
                return $this->handleTypeDestination($request);
            case 'time.action';
                return $this->handleTimeDestination($request);
            case 'highlight_des.action':
                return $this->handleHighlightDestination($request);
            case 'pricetour.action';
                return $this->handlePriceTour($request);
            case 'vehical.action';
                return $this->handleVehicalTour($request);
            case 'de_re.action';
                return $this->handleDepartureReturnDay($request);
            case 'tour_dedes.action';
                return $this->handleDeDesTour($request);
            case 'aroundpricetour.action';
                return $this->handleAroundPriceTour($request);
            case 'tourdetail.action';
                return $this->handleTourDetail($request);
            default:
                return response()->json(['fulfillmentText' => 'Xin chào, tôi có thể giúp gì cho bạn']);
        }
    }

    public function handleDestination(Request $request)
    {
        // Cho biết địa chỉ của các địa cđiểm du lịch
        $name_des = trim($request->input('queryResult.parameters.namedes') ?? null);
        // Log::info($name_des);
        if ($name_des) {
            $destinationName = Destination::where('name_des', 'like', '%' . $name_des . '%')->first();
            if ($destinationName) {
                $response = [
                    'fulfillmentText' => 'Địa chỉ ' . $destinationName->name_des . ' nằm ở ' . $destinationName->address,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch bạn muốn',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch bạn muốn',
            ];
        }

        return response()->json($response);
    }

    public function handleViewDes(Request $request)
    {
        $destination = trim($request->input('queryResult.parameters.namedes') ?? null);
        if ($destination) {
            $qDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();
            $qDesView = $qDestination->detail;
            // Log::info($qDesView);
            if ($qDestination) {
                $response = [
                    'fulfillmentText' => $qDesView->views,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handleActivityDes(Request $request)
    {
        $destination = trim($request->input('queryResult.parameters.namedes') ?? null);
        if ($destination) {
            $qDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();
            $qDesActivities = $qDestination->detail;
            // Log::info($qDestination);
            if ($qDestination) {
                $response = [
                    'fulfillmentText' => $qDesActivities->activities,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handleFoodDes(Request $request)
    {
        $namedes = trim($request->input('queryResult.parameters.namedes') ?? null);
        $food = trim($request->input('queryResult.parameters.food') ?? null);
        if ($namedes && !$food) {
            $qDestination = Destination::where('name_des', 'like', '%' . $namedes . '%')->first();
            $qDesFoods = $qDestination->foods;
            $arrFoods = [];
            foreach ($qDesFoods as $food) {
                array_push($arrFoods, $food['name_food']);
            }
            $arrFoodString = implode('\n', $arrFoods);
            // Log::info($arrFoodString);
            if ($qDestination) {
                $response = [
                    'fulfillmentText' => 'Một số món ăn đặc sản quanh đây là ' . $arrFoodString,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn yêu cầu',
                ];
            }
        } else {
            $qFood = DestinationFoodDetail::where('name_food', 'like', '%' . $food . '%')->first();
            if (!$qFood) {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy món ăn bạn yêu cầu',
                ];
            }
            // Log::info($qFood);
            $response = [
                'fulfillmentMessages' => [
                    [
                        'text' => [
                            'text' => [
                                $qFood->description . PHP_EOL .
                                    'Dưới đây là hình ảnh của món ăn:'
                            ]
                        ]
                    ],
                    [
                        'payload' => [
                            'richContent' => [
                                [
                                    [
                                        'type' => 'image',
                                        'rawUrl' => $qFood->image_path,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            // Log::info($response);
        }
        return response()->json($response);
    }

    public function handleImageDes(Request $request)
    {
        $destination = trim($request->input('queryResult.parameters.namedes') ?? null);
        $urlLocal = 'http://127.0.0.1:8000';
        if ($destination) {
            $qDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();
            $imageDesDetail = $qDestination->images->take(3);
            $arrImage = [];
            foreach ($imageDesDetail as $imageDes) {
                $arrImage[] = [
                    'type' => 'image',
                    'rawUrl' => $urlLocal . $imageDes['image_path'],
                ];
            }

            $arrImage[] = [
                'type' => 'button',
                'icon' => [
                    'type' => 'chevron_right',
                    'color' => '#228B22'
                ],
                'text' => 'Xem chi tiết',
                'link' => url('chi-tiet-dia-diem/' . $qDestination->id . '/' . $qDestination->slug)
            ];

            if ($qDestination) {
                $response = [
                    'fulfillmentMessages' => [
                        [
                            'text' => [
                                'text' => [
                                    'Dưới đây là một số hình ảnh về ' . $destination
                                ]
                            ]
                        ],
                        [
                            'payload' => [
                                'richContent' => [
                                    $arrImage,
                                ]
                            ],
                        ]
                    ]
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handleVideoDes(Request $request)
    {
        $destination = trim($request->input('queryResult.parameters.namedes') ?? null);
        $videoUrl = 'https://vn.video.search.yahoo.com/search/video?fr=mcafee&ei=UTF-8&p=video+v%E1%BB%81+qu%E1%BA%A7n+th%E1%BB%83+l%E1%BB%99c+v%E1%BB%ABng+ph%C3%BA+th%E1%BB%8D&type=E210VN91215G0#id=5&vid=54b4731bf9f006599278b30d86d4585b&action=click';
        $urlLocal = 'http://127.0.0.1:8000';
        if ($destination) {
            $qDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();
            $response = [
                'fulfillmentMessages' => [
                    [
                        'text' => [
                            'text' => [
                                'Dưới đây là video về ' . $destination
                            ]
                        ]
                    ],
                    [
                        'payload' => [
                            'richContent' => [
                                [
                                    [
                                        'type' => 'image',
                                        'rawUrl' => $urlLocal . $qDestination->feature_image_path,
                                        'subtitle' => 'Video về ' . $destination,
                                        'actionLink' => $videoUrl
                                    ],
                                    [
                                        'type' => 'button',
                                        'icon' => [
                                            'type' => 'chevron_right',
                                            'color' => '#228B22'
                                        ],
                                        'text' => 'Xem video',
                                        'link' => $videoUrl,
                                    ]
                                ]
                            ]
                        ],
                    ]
                ]
            ];
            Log::info($response);
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch bạn muốn',
            ];
        }
        return response()->json($response);
    }

    public function handlePriceDestination(Request $request)
    {
        $destination = trim($request->input('queryResult.parameters.namedes') ?? null);

        if ($destination) {
            $priceDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();

            if ($priceDestination) {
                if ($priceDestination->ticket_price == 'Miễn phí') {
                    $response = [
                        'fulfillmentText' => 'Giá vé vào địa điểm ' . $priceDestination->name_des . ' là ' . $priceDestination->ticket_price,
                    ];
                    // Log::info($response);
                } else {
                    $response = [
                        'fulfillmentText' => 'Giá vé vào địa điểm ' . $priceDestination->name_des . ' có giá: ' . number_format($priceDestination->ticket_price) . ' VNĐ',
                    ];
                }
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch bạn muốn',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch bạn muốn',
            ];
        }
        return response()->json($response);
    }

    public function handleAddress(Request $request)
    {
        // Gợi ý các địa điểm du lịch theo địa chỉ
        $address = trim($request->input('queryResult.parameters.address') ?? null);
        Log::info($address);

        if ($address) {
            $destinationAddress = Destination::where('address', 'like', '%' . $address . '%')->get();
            // Log::info($destinationAddress);
            if ($destinationAddress->isNotEmpty()) {
                $arrDes = [];
                foreach ($destinationAddress as $index => $addressItem) {
                    array_push($arrDes, ($index + 1) . ': ' . $addressItem->name_des);
                }
                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Các địa điểm du lịch ở ' . $address . ":\n" . $stringDes
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa chỉ mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa chỉ mà bạn yêu cầu',
            ];
        }
        return response()->json($response);
    }

    public function handleTicketFree(Request $request)
    {
        $freePrices = $request->input('queryResult.parameters.freeticket') ?? null;
        $addressOfAroundTicket = trim($request->input('queryResult.parameters.address') ?? null);
        // Log::info($addressOfAroundTicket);
        // Log::info($freePrices);
        if ($addressOfAroundTicket && $freePrices) {
            $ticketFreeFollowAddress = Destination::where('ticket_price', 'like', '%' . $freePrices . '%')
                ->where('address', 'like', '%' . $addressOfAroundTicket . '%')
                ->get();
            Log::info($ticketFreeFollowAddress);
            if ($ticketFreeFollowAddress->isNotEmpty()) {
                $arrDes = [];
                foreach ($ticketFreeFollowAddress as $index => $recordItem) {
                    array_push($arrDes, $index + 1 . ': ' . $recordItem->name_des);
                }

                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Các địa điểm du lịch hấp dẫn miễn phí nằm ở ' . $addressOfAroundTicket . "là:\n" . $stringDes,
                ];
            } else {
                Log::info('hello');
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm nào có địa chỉ và khoảng giá đó cả',
                ];
            }
        } elseif ($freePrices) {

            $freeTickets = Destination::where('ticket_price', 'like', '%' . $freePrices . '%')->get();
            if ($freeTickets->isNotEmpty()) {
                $arrDes = [];
                foreach ($freeTickets as $index => $freeTicket) {
                    array_push($arrDes, $index + 1 . ': ' . $freeTicket->name_des);
                }
                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Những địa điểm có giá miễn phí là ' . "\n" . $stringDes,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi không có địa điểm nào miễn phí'
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm hay giá mà bạn yêu cầu'
            ];
        }


        return response()->json($response);
    }
    public function handleTicketPrice(Request $request)
    {
        $ticketPrices = $request->input('queryResult.parameters.ticketprice') ?? null;
        $addressOfAroundTicket = trim($request->input('queryResult.parameters.address') ?? null);

        // Gợi ý các khu du lịch khoảng giá theo địa chỉ
        // Log::info($addressOfAroundTicket);
        if ($addressOfAroundTicket && $ticketPrices) {
            $minPrice = $ticketPrices[0];
            $maxPrice = $ticketPrices[1];
            $ticketAroundFollowAddress = Destination::whereBetween('ticket_price', [$minPrice, $maxPrice])
                ->where('address', 'like', '%' . $addressOfAroundTicket . '%')
                ->get();

            if ($ticketAroundFollowAddress->isNotEmpty()) {
                $arrDes = [];
                foreach ($ticketAroundFollowAddress as $index => $recordItem) {
                    array_push($arrDes, $index + 1 . ': ' . $recordItem->name_des);
                }

                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Các địa điểm du lịch hấp dẫn giá khoảng ' . number_format($minPrice)  . 'VNĐ đến ' . number_format($maxPrice)  . 'VNĐ nằm ở ' . $addressOfAroundTicket . " là:\n " . $stringDes,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm nào có địa chỉ và khoảng giá đó cả',
                ];
            }
        } elseif (count($ticketPrices) == 2) {
            $minPrice = $ticketPrices[0];
            $maxPrice = $ticketPrices[1];
            $priceAroundTickets = Destination::whereBetween('ticket_price', [$minPrice, $maxPrice])->get();
            if ($priceAroundTickets->isNotEmpty()) {
                $arrDes = [];
                foreach ($priceAroundTickets as $index => $priceTicket) {
                    array_push($arrDes, $index + 1 . ': ' . $priceTicket->name_des);
                }
                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Những địa điểm có giá từ ' . number_format($minPrice) . 'đ đến ' . number_format($maxPrice) . "đ là:\n " . $stringDes,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch nào khoảng giá đó cả',
                ];
            }
        } elseif (count($ticketPrices) == 1) {
            $priceTicket = $ticketPrices[0];
            $priceTickets = Destination::where('ticket_price', $priceTicket)->get();
            Log::info($priceTickets);
            $arrDes = [];
            foreach ($priceTickets as $index => $priceTicketItem) {
                array_push($arrDes, $index + 1 . ': ' . $priceTicketItem->name_des);
            }
            $stringDes = implode("\n", $arrDes);
            // Log::info($stringDes);
            $response = [
                'fulfillmentText' => 'Những địa điểm có khoảng giá ' . number_format($priceTicket) . "đ là:\n " . $stringDes,
            ];
        } else {
            return $this->handleTicketFree($request);
        }
        return response()->json($response);
    }

    public function handleFreeFollowDes(Request $request)
    {
        // Gợi ý những địa điểm có vé vào miễn phí theo địa chỉ
        $freeTicket = $request->input('queryResult.parameters.freeticket') ?? null;
        $addressOfFreeTicket = trim($request->input('queryResult.parameters.address') ?? null);
        // Log::info($addressOfFreeTicket);

        if ($addressOfFreeTicket && $freeTicket) {
            $ticketFreeFollowAddress = Destination::where('ticket_price', 'like', '%' . $freeTicket . '%')
                ->where('address', 'like', '%' . $addressOfFreeTicket . '%')
                ->get();

            if ($ticketFreeFollowAddress->isNotEmpty()) {
                $arrDes = [];
                foreach ($ticketFreeFollowAddress as $index => $recordItem) {
                    array_push($arrDes, $index + 1 . ': ' . $recordItem->name_des);
                }

                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Các địa điểm du lịch ở ' . $addressOfFreeTicket . " có vé vào miễn phí là:\n " . $stringDes,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm du lịch miễn phí mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm miễn phí mà bạn yêu cầu',
            ];
        }
        return response()->json($response);
    }

    public function handleTypeDestination(Request $request)
    {
        // Những địa điểm theo thể loại
        $typeDestination = trim($request->input('queryResult.parameters.typedestination')) ?? null;
        $destination = trim($request->input('queryResult.parameters.namedes')) ?? null;

        if ($destination) {
            $categoryDestination = Destination::where('name_des', 'like', '%' . $destination . '%')->first();
            $typeDestinations = $categoryDestination->category;
            // Log::info($typeDestinations->name);
            $response = [
                'fulfillmentText' => 'Địa điểm ' . $destination . ' là loại hình: ' . $typeDestinations->name,
            ];
            return response()->json($response);
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm mà bạn yêu cầu',
            ];
        }


        if ($typeDestination) {

            $categories = Category::where('name', 'like', '%' . $typeDestination . '%')->first();

            if ($categories) {
                $categoryDestinations = $categories->destinations;
                $arrDes = [];
                foreach ($categoryDestinations as $index => $categoryDestination) {
                    array_push($arrDes, $index + 1 . ': ' . $categoryDestination->name_des);
                }
                $stringDes = implode("\n", $arrDes);
                // Log::info($stringDes);
                $response = [
                    'fulfillmentText' => 'Các địa điểm du lịch về ' . $typeDestination . " là:\n " . $stringDes,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy loại hình du lịch mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy loại hình du lịch mà bạn yêu cầu',
            ];
        }
        return response()->json($response);
    }

    public function handleTimeDestination(Request $request)
    {
        $namedes = trim($request->input('queryResult.parameters.namedes') ?? null);
        $time = trim($request->input('queryResult.parameters.time') ?? null);
        $typeDes = trim($request->input('queryResult.parameters.typedestination') ?? null);
        // Log::info($typeDes);
        $dateTime = new DateTime($time);
        $hour = $dateTime->format('g:i:s');
        // Log::info($typeDes);
        if ($namedes) {
            // $start = microtime(true);
            $qRecordDes = Destination::select('open_time', 'close_time')->where('name_des', 'like', '%' . $namedes . '%')->first();
            // $end = microtime(true);
            // $executionTime = ($end - $start);
            // Log::info('Query Execution Time: ' . $executionTime . ' seconds');
            // Log::info($qRecordDes->open_time);
            if ($qRecordDes->open_time && $qRecordDes->close_time) {
                $response = [
                    'fulfillmentText' =>  $namedes . ' mở cửa vào lúc ' . $qRecordDes->open_time . ' và đóng cửa vào lúc ' . $qRecordDes->close_time,
                ];
            } elseif (!$qRecordDes->open_time) {
                $response = [
                    'fulfillmentText' => $namedes . ' mở cửa cả ngày',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handleHighlightDestination(Request $request)
    {
        $namedes = trim($request->input('queryResult.parameters.namedes') ?? null);
        // Log::info($namedes);
        if ($namedes) {
            $qNameDes = Destination::where('name_des', 'like', '%' . $namedes . '%')->first();
            if ($qNameDes) {
                $response = [
                    'fulfillmentText' =>  strip_tags($qNameDes->description),
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi tôi không tìm thấy địa điểm mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handlePriceTour(Request $request)
    {
        $nametour = trim($request->input('queryResult.parameters.nametour') ?? null);
        if ($nametour) {
            $qPriceTour = Tour::where('name_tour', 'like', '%' . $nametour . '%')->first();
            if ($qPriceTour) {
                if ($qPriceTour->sale_price) {
                    $response = [
                        'fulfillmentText' => 'Tour '  . $nametour . ' đang có ưu đãi giảm giá từ: ' . number_format($qPriceTour->price) . 'đ/người xuống còn ' . number_format($qPriceTour->sale_price) . 'đ/người ' . PHP_EOL .
                            'Người lớn (trên 12 tuổi): ' . number_format($qPriceTour->price_adult) . 'đ' . PHP_EOL .
                            'Trẻ em (từ 2 đến 12 tuổi): ' . number_format($qPriceTour->price_child) . 'đ' . PHP_EOL .
                            'Sơ sinh (dưới 2 tuổi): ' . number_format($qPriceTour->price_infant) . 'đ',
                    ];
                } else {
                    $response = [
                        'fulfillmentText' => 'Chi tiết giá của tour: ' . $nametour . PHP_EOL .
                            'Người lớn (trên 12 tuổi): ' . number_format($qPriceTour->price_adult) . 'đ' . PHP_EOL .
                            'Trẻ em (từ 2 đến 12 tuổi): ' . number_format($qPriceTour->price_child) . 'đ' . PHP_EOL .
                            'Sơ sinh (dưới 2 tuổi): ' . number_format($qPriceTour->price_infant) . 'đ',
                    ];
                }
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy tour mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }

    public function handleVehicalTour(Request $request)
    {
        $nametour = trim($request->input('queryResult.parameters.nametour') ?? null);
        if ($nametour) {
            $vehicalTour = Tour::where('name_tour', 'like', '%' . $nametour . '%')->first();
            if ($vehicalTour) {
                $response = [
                    'fulfillmentText' => 'Phương tiện di chuyển của tour là ' . $vehicalTour->type_vehical,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn yêu cầu'
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm mà bạn yêu cầu',
            ];
        }
        return response()->json($response);
    }

    public function handleDepartureReturnDay(Request $request)
    {
        $nametour = trim($request->input('queryResult.parameters.nametour') ?? null);
        // Log::info($nametour);
        if ($nametour) {
            $qDay = Tour::where('name_tour', 'like', '%' . $nametour . '%')->first();
            if ($qDay) {
                $response = [
                    'fulfillmentText' => 'Tour ' . $nametour . ' sẽ xuất phát vào ngày ' . date('d/m/Y', strtotime($qDay->departure_day)) . ' và trở về vào ngày ' . date('d/m/Y', strtotime($qDay->return_day)),
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm nào mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy địa điểm bạn mà bạn yêu cầu',
            ];
        }
        return response()->json($response);
    }

    public function handleDeDesTour(Request $request)
    {
        $tourDeparture = $request->input('queryResult.parameters.departure') ?? null;
        $tourDestination = $request->input('queryResult.parameters.destination') ?? null;
        // Log::info();
        if ($tourDeparture && $tourDestination) {
            $qTours = Tour::where('departure', 'like', '%' . $tourDeparture[0] . '%')
                ->where('destination', 'like', '%' . $tourDestination[0] . '%')
                ->get();

            // Log::info($qTours);
            $arrTour = [];
            if ($qTours->isNotEmpty()) {
                foreach ($qTours as $index => $qTour) {
                    array_push($arrTour, $index + 1 . ': ' . $qTour->name_tour);
                }
                $stringTour = implode("\n", $arrTour);
                // Log::info($stringTour);
                $response = [
                    'fulfillmentText' => 'Những tour xuất phát từ ' . $tourDeparture[0] . ' đến ' . $tourDestination[0] . " là\n " . $stringTour,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy tour có điểm xuất phát và điểm đến như bạn yêu cầu',
                ];
            }
        } elseif ($tourDeparture) {
            $qTourDepartures = Tour::where('departure', 'like', '%' . $tourDeparture[0] . '%')->get();
            // Log::info($qTourDepartures);
            $arrTour = [];
            if ($qTourDepartures->isNotEmpty()) {
                foreach ($qTourDepartures as $index =>  $qTourDeparture) {
                    array_push($arrTour, $index + 1 . ': ' . $qTourDeparture->name_tour);
                }
                $stringTour = implode("\n", $arrTour);
                // Log::info($stringTour);
                $response = [
                    'fulfillmentText' => 'Những tour xuất phát từ ' . $tourDeparture[0] . " là\n " . $stringTour,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy điểm đến hoặc điểm đi mà bạn yêu cầu',
                ];
            }
        } elseif ($tourDestination) {
            $qTourDestinations = Tour::where('destination', 'like', '%' . $tourDestination[0] . '%')->get();
            $arrTour = [];
            if ($qTourDestinations->isNotEmpty()) {
                foreach ($qTourDestinations as $index => $qTourDestination) {
                    array_push($arrTour, $index + 1 . ': ' . $qTourDestination->name_tour);
                }
                $stringTour = implode("\n", $arrTour);
                // Log::info($stringTour);
                $response = [
                    'fulfillmentText' => 'Những tour đến ' . $tourDestination[0] . " là\n " . $stringTour,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy những tour có điểm đến mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, bạn có thể nói rõ hơn được không ?',
            ];
        }
        return response()->json($response);
    }

    public function handleAroundPriceTour(Request $request)
    {
        $pricestour = $request->input('queryResult.parameters.pricetour') ?? null;
        // Log::info($pricestour);

        if (count($pricestour) == 2) {
            $minPrice = $pricestour[0];
            $maxPrice = $pricestour[1];
            $qAroundPricesTour = Tour::whereBetween('sale_price', [$minPrice, $maxPrice])
                ->orWhereBetween('price', [$minPrice, $maxPrice])
                ->get();
            if ($qAroundPricesTour->isNotEmpty()) {
                $arrTours = [];
                foreach ($qAroundPricesTour as $index => $qPricesTourItem) {
                    array_push($arrTours, $index + 1 . ': ' . $qPricesTourItem->name_tour);
                }
                $stringTour = implode("\n", $arrTours);
                $response = [
                    'fulfillmentText' => 'Những tour có giá khoảng từ ' . number_format($minPrice) . 'đ đến ' .  number_format($maxPrice) . "đ là:\n " . $stringTour,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy giá bạn mong muốn',
                ];
            }
        } elseif (count($pricestour) == 1) {
            // Log::info('Hello');
            $price = $pricestour[0];
            $qPricesTours = Tour::where('sale_price', $price)->get();
            $arrTours = [];
            foreach ($qPricesTours as $index => $qPricesTourItem) {
                array_push($arrTours, $index + 1 . ': ' . $qPricesTourItem->name_tour);
            }
            $stringTour = implode("\n", $arrTours);
            $response = [
                'fulfillmentText' => 'Những tour có giá khoảng ' . number_format($price) . "đ là:\n " . $stringTour,
            ];
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy tour nào có khoảng giá đó cả'
            ];
        }
        return response()->json($response);
    }

    public function handleTourDetail(Request $request)
    {
        $nametour = trim($request->input('queryResult.parameters.nametour') ?? null);
        if ($nametour) {
            $qTour = Tour::where('name_tour', 'like', '%' . $nametour . '%')->first();
            // Log::info('Số kết quả: ' . $qTour->count());
            // Log::info($qTour);
            if ($qTour) {
                $response = [
                    'fulfillmentText' => 'Thông tin chi tiết về tour ' . $nametour . ': ' . PHP_EOL .
                        'Giá tour: ' . number_format($qTour->sale_price) . 'đ' . PHP_EOL .
                        'Giá người lớn (trên 12 tuổi): ' . number_format($qTour->price_adult) . 'đ' . PHP_EOL .
                        'Giá trẻ em (2-12 tuổi): ' . number_format($qTour->price_child) . 'đ' . PHP_EOL .
                        'Giá sơ sinh (dưới 2 tuổi): ' . number_format($qTour->price_infant) . 'đ' . PHP_EOL .
                        'Điểm xuất phát: ' . $qTour->departure . PHP_EOL .
                        'Ngày đi: ' . date('d/m/Y', strtotime($qTour->departure_day)) . PHP_EOL .
                        'Ngày về: ' . date('d/m/Y', strtotime($qTour->return_day)) . PHP_EOL .
                        'Sô người hiện tại tham gia: ' . $qTour->participants . '/' . $qTour->max_participants . 'người' . PHP_EOL,
                ];
            } else {
                $response = [
                    'fulfillmentText' => 'Xin lỗi, tôi không tìm thấy tour mà bạn yêu cầu',
                ];
            }
        } else {
            $response = [
                'fulfillmentText' => 'Xin lỗi, tôi bạn nói rõ hơn được không',
            ];
        }
        return response()->json($response);
    }
}
