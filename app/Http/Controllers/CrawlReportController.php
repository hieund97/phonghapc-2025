<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\CrawlReport;
use App\Http\Requests\CrawlReportStore;
use App\Http\Requests\CrawlReportUpdate;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrawlReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('crawl_report.index');
        $aryCrawlData = $this->getListCrawl($request);

        return view('crawl_report.index', compact('aryCrawlData'));
    }

    protected function getListCrawl(Request $request)
    {
        $crawl = CrawlReport::filter($request->all());

        if ($request->has('product_category')) {
            $value = $request->product_category;
            $crawl->where(function (Builder $query) use ($value) {
                $query->whereHas('product', function (Builder $query2) use ($value) {
                    $query2->where(function ($q) use($value) {
                        $q->whereHas('categories', function (Builder $query3) use ($value) {
                            $query3->whereIn('id', $value);
                        });
                    });
                });
            });
        }

        return $crawl->orderByDesc('id')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crawl_report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrawlReportStore $request)
    {
        $data              = $request->validated();
        $aryProductCrawled = [
            'name'  => $data['product_new_name'],
            'price' => $data['product_new_price'],
            'image' => $data['product_new_image']
        ];

        $data['info_product_url'] = json_encode($aryProductCrawled);
        $crawl                    = CrawlReport::create($data);

        return redirect()
            ->back()
            ->with('success', __('Created crawl report'))
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CrawlReport $crawlReport
     * @return \Illuminate\Http\Response
     */
    public function edit(CrawlReport $crawlReport)
    {
        $currentCrawlData = $crawlReport;

        return view('crawl_report.create', compact('currentCrawlData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CrawlReport  $crawlReport
     * @return \Illuminate\Http\Response
     */
    public function update(CrawlReportUpdate $request, CrawlReport $crawlReport)
    {
        $data = $request->validated();

        $aryProductCrawled = [
            'name'  => $data['product_new_name'],
            'price' => $data['product_new_price'],
            'image' => $data['product_new_image']
        ];

        $data['info_product_url'] = json_encode($aryProductCrawled);

        $crawlReport->update($data);

        return redirect()
            ->back()
            ->with('success', __('Updated Crawl Data'))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CrawlReport $crawlReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrawlReport $crawlReport)
    {
        $this->authorize('crawl_report.destroy');
        $crawlReport->delete();
    }

    /**
     * Update price by crawled price
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickUpdate(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $product->update([
            'sale_price' => $request->price,
        ]);

        if (!empty($request->crawl_id)) {
            $crawl = CrawlReport::findOrFail($request->crawl_id);

            $crawl->update([
                'status' => 1
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Cập nhật thành công'], 200);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function quickUpdateFollow(Request $request): JsonResponse
    {
        $type       = $request->input('type');
        $value      = $request->input('value');
        $crawlId    = $request->input('crawl_id');
        $dataUpdate = [$type => $value];

        $result = CrawlReport::where('id', $crawlId)->update($dataUpdate);

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
