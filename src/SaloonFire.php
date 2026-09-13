<?php

  namespace Tobya\SaloonFire;


  use Saloon\Http\Response;
  use Saloon\Http\Request;


  class SaloonFire
  {
        protected $disableCaching = false;

        protected $shouldReturnRequest = false;

        protected $connector;


      /**
       * Disable Caching for this and all future requests. Caching will remain
       * disabled (for duration of request cycle) until explicity set to false;
       * @param $disableCaching
       * @return $this
       */
        public function disableCaching($disableCaching = true) : static
        {
            $this->disableCaching = $disableCaching;
            return $this;
        }



      /**
       * Process any modification to Request.
       * @param Request $request
       * @return Response
       */
        protected function applymodifiers(Request $request) : Request
        {

            if ( $this->disableCaching ){

              if(method_exists($request,'disableCaching'))
              {
                $request->disableCaching();
              }

            }
            return $request;
        }


          Protected function getRequest_or_SendForResult($request )
          {
                // apply any modifiers
                $request = $this->applymodifiers($request);

                // if getRequest() has been called, don't actually send request to server,
                // just return the request to caller.
                if ($this->shouldReturnRequest){
                    return $request;
                }

                return $this->send($request);
          }



          public function getRequest($return = true) : static
          {
              $this->shouldReturnRequest = $return;
              return $this;
          }

          public function send(Request $request ) : Response
          {
                return $this->connector->send($request);
          }
  }
