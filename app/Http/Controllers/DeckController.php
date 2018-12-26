<?php

namespace App\Http\Controllers;

use App\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    protected $curl_url;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->curl_url = 'http://www.keyforgegame.com/api/decks/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deck.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kf_id' => 'bail|required|unique:decks',
            'name' => 'bail|required|unique:decks'
        ]);
        // TODO implement a validator
        if (isset($request->id) && isset($request->name)) {
            $player_id = Auth::user()->player()->first()->id;
            $deck = Deck::create([
                'player_id' => $player_id,
                'name' => $request->name,
                'kf_id' => $request->id,
            ]);
        }
        return $deck;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deck  $deck
     * @return \Illuminate\Http\Response
     */
    public function show(Deck $deck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deck  $deck
     * @return \Illuminate\Http\Response
     */
    public function edit(Deck $deck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deck  $deck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deck $deck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deck  $deck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deck $deck)
    {
        //
    }

    public function findDecks(Request $request)
    {
        $search_string = $this->curl_url.'?page=1&page_size=10&search=';
        if ($request->name) {
            $search_string.=rawurlencode($request->name);
        } else {
            return;
        }
        // if (APP_ENV == 'local') {
        //     return '{"count":3,"data":[{"id":"14dc851e-ab25-4aac-8c5e-f11aa8ec24af","name":"Grun, Tiresome Temple Oracle","expansion":341,"power_level":0,"chains":0,"wins":0,"losses":0,"is_my_deck":false,"cards":["aa9b8dfe-3817-4f9d-b4c8-95c5c303c513","aa9b8dfe-3817-4f9d-b4c8-95c5c303c513","a429a71c-e558-4ee6-af48-6326df3d4b0f","1ca5f524-5a24-4a58-aacf-8204bdb46a32","2cb1f58c-5979-4d3a-ae86-9dadc6000288","3c5c1881-486c-4911-a3ce-497ef258e8ba","45d564a2-fcc9-4baa-8dc8-8e1a0fe2a37a","5a1ee413-4b39-467f-a0bf-e5935f1edf9b","57bccc52-b6a1-4d11-b9d9-6356d8ac279c","cd83ebe7-f961-4e5e-a00e-046d1be5e5d3","53f7d3ec-a65f-4b05-8c82-74f44a7bdc44","3230691b-9a36-4591-a43c-c9d17fd1a1ef","23508e89-0431-45d1-9692-192c6dffeb5a","23508e89-0431-45d1-9692-192c6dffeb5a","35bacc2e-48d6-4dac-a11c-5986e7416ddc","a936b45d-5de6-4b43-889b-9c58f0ab4c35","bbd788cd-1f8d-4950-a7c1-bc7fe5c0d49a","9c75188a-8cb2-4201-9f10-d13f6cd00255","9c75188a-8cb2-4201-9f10-d13f6cd00255","15f1a6f4-873f-4fa9-a080-7f01e72bbff1","eb91efae-9fbe-46e2-a6f4-f93d290703a9","11663693-8a10-4783-9f89-47f43c49bfa3","11663693-8a10-4783-9f89-47f43c49bfa3","03c4165e-a0bb-4fd5-b6a8-e3d9aec0551e","98fca3bb-b74c-4563-876b-7c9e942e8254","68fbba20-4516-4e8a-8d3d-47e2cb401032","3f0f006a-10bc-4f1a-a90a-a64abb14d5a0","c5e95ea2-fd32-4ab8-964a-720993f80d1b","dc6344a9-0486-4926-a820-d99eb2151c7f","f0c4cb0f-8e5f-454c-a6ad-35f35ac3c98a","439d9d6e-7abf-4a7a-83d5-77060b5668cc","ddd62eb0-4699-4fb0-9b63-43769186b509","3cd0e141-6115-4719-a09e-8e0867fe567c","3cd0e141-6115-4719-a09e-8e0867fe567c","dc0ba4ea-6f6e-475f-899c-88ad45ccae94","05fa104f-3719-41d0-9189-57ff3ec5edc1"],"notes":[],"is_my_favorite":false,"casual_wins":0,"casual_losses":0,"_links":{"houses":["Logos","Shadows","Untamed"]}},{"id":"e7904315-4d09-4951-817b-b760fcfca072","name":"Romilly, Quarrelsome Temple Outlaw","expansion":341,"power_level":0,"chains":0,"wins":0,"losses":0,"is_my_deck":false,"cards":["be492d70-5c87-441e-8223-79fb2bce85c9","aa73a693-e1e6-4097-8010-ddc820cc6d96","ea2a390e-e121-4cbd-96c5-2430cc600e81","9ba24b81-1887-46fd-9ec4-d8851af7e574","23a96d73-4eb2-4c45-9550-8207145eb587","f97316b0-75a4-45a4-8735-15e72cc1568c","916f271b-9928-437c-bfc4-d60d32af8c7c","39f255c4-2ca4-4e7e-ba44-88ac0fcaeb1b","c9625085-6eb2-4555-87cd-cda180af9f71","3c4513a3-260e-441f-8abf-b27c1c4e23ef","b8343462-b5d7-48b0-9e3b-f020c5e73c55","365b2432-0b7f-4f67-9fa6-e4b726de5c4e","aa9b8dfe-3817-4f9d-b4c8-95c5c303c513","1838fbaa-a062-4593-acbe-53ecfadfb5cc","1838fbaa-a062-4593-acbe-53ecfadfb5cc","a429a71c-e558-4ee6-af48-6326df3d4b0f","953bbe23-df2b-4459-a3f6-beca7cd49a34","59cb3ad9-cc98-4fe5-8589-a8967d32af00","5a1ee413-4b39-467f-a0bf-e5935f1edf9b","d6aae364-d547-49ec-83dd-be3ffbcb80c6","57bccc52-b6a1-4d11-b9d9-6356d8ac279c","c08c91f0-043a-4a8a-8761-6080e9f46183","c08c91f0-043a-4a8a-8761-6080e9f46183","bec84d69-68f0-456c-a7bd-9f1e94d55a22","f96b20b3-df0e-4d43-a737-e7fa56ff690b","f96b20b3-df0e-4d43-a737-e7fa56ff690b","68fbba20-4516-4e8a-8d3d-47e2cb401032","459a6725-dcc0-4967-8cd4-a9bbb1548eda","c0ab6f27-619e-4b17-a623-c70f4cd84026","f04a582c-c50b-453e-afc8-9d459c46cc22","afe27535-5cb7-43a1-8eab-ff9a6a472edb","f0c4cb0f-8e5f-454c-a6ad-35f35ac3c98a","013def76-9edc-495c-bc35-af6210192f6b","3cd0e141-6115-4719-a09e-8e0867fe567c","c8ed04c1-d938-4d96-a284-6e0f6a2b116e","3a3783ea-b5c4-407d-b3c7-0003c562a9aa"],"notes":[],"is_my_favorite":false,"casual_wins":0,"casual_losses":0,"_links":{"houses":["Dis","Logos","Untamed"]}},{"id":"d00f9236-2948-41aa-aa67-87627dd69ac5","name":"Blizzov, the Tiresome Temple Elder","expansion":341,"power_level":0,"chains":0,"wins":0,"losses":0,"is_my_deck":false,"cards":["ce051448-1745-4606-95a0-e44e70401ba1","7176b276-d696-4b53-8990-e78d94583d0b","2cb1f58c-5979-4d3a-ae86-9dadc6000288","448c1335-d45b-473e-b222-d71f31ba0292","dc18cfc1-9dd9-440d-93be-50c2c114b3c8","3c5c1881-486c-4911-a3ce-497ef258e8ba","2ec5cbf6-3c41-41ef-9cb7-33a0601fd607","2ec5cbf6-3c41-41ef-9cb7-33a0601fd607","57bccc52-b6a1-4d11-b9d9-6356d8ac279c","2f9f20aa-b110-4df8-8f4e-560a11f0ae49","37a73724-a6e5-457f-8fde-fa792efa18ab","b68e10b3-275e-46b8-8227-fe02984ff525","3056e60c-8f7c-40da-951c-6e0e9cfb9d46","3056e60c-8f7c-40da-951c-6e0e9cfb9d46","818f90a4-e896-4ba2-91ea-0d1232e94058","89b647b4-74b1-4e74-9812-1581e088f32e","9a146bd4-7017-49ab-9e59-3ddbbb18d210","c88c632e-743e-4f81-a9de-f61cddcbcaf5","c88c632e-743e-4f81-a9de-f61cddcbcaf5","22fdfc0f-5ea1-42bd-984a-8c9edd8b16b7","9779c7a8-419a-4c99-9460-a48ddf33b963","eec2bfbf-d019-4a7f-a0fa-2b8c8f16cd8d","116f4590-792e-4d5f-ab06-94dbf7ba85d3","116f4590-792e-4d5f-ab06-94dbf7ba85d3","8754c688-6d87-4372-bbec-349e4e4bdded","c5f7e033-f62e-442e-97a1-b23b47cde1e8","f6d5781c-83a4-4070-bf98-085e81063c26","253588cf-4fd5-4022-9c5c-a2b3693e21f0","15f1a6f4-873f-4fa9-a080-7f01e72bbff1","afa69425-4fe4-4e5b-a016-7c142ed0a849","23099339-dbe2-4b35-b26b-9dfb4c0fb35a","d988a134-ff29-40f7-bac7-3fd49fe525f8","3a0c1861-3d38-4167-b0c1-afaa9cbe5e50","429e5d71-40bc-4ff4-ae81-4d5c0c10d15e","11663693-8a10-4783-9f89-47f43c49bfa3","21a5a8b1-4d19-43f2-8e8d-bd7a7531099d"],"notes":[],"is_my_favorite":false,"casual_wins":0,"casual_losses":0,"_links":{"houses":["Logos","Sanctum","Shadows"]}}],"_linked":{"houses":[{"id":"Dis","name":"Dis","image":"https://cdn.keyforgegame.com/media/houses/Dis_OooSNPO.png"},{"id":"Logos","name":"Logos","image":"https://cdn.keyforgegame.com/media/houses/Logos_2mOY1dH.png"},{"id":"Shadows","name":"Shadows","image":"https://cdn.keyforgegame.com/media/houses/Shadows_z0n69GG.png"},{"id":"Sanctum","name":"Sanctum","image":"https://cdn.keyforgegame.com/media/houses/Sanctum_lUWPG7x.png"},{"id":"Untamed","name":"Untamed","image":"https://cdn.keyforgegame.com/media/houses/Untamed_bXh9SJD.png"}]}}';
        // }

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $search_string,
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        echo($resp);
        echo($search_string);
        return;
    }
}
