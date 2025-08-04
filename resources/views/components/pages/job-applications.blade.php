@extends('components.layout.app')
@section('content')
<div style="width: 1280px; height: 832px; min-height: 832px; padding-bottom: 100px; position: relative; background: #F6F6F6; overflow: hidden; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
 
  <div style="align-self: stretch; flex: 1 1 0; padding-top: 32px; padding-left: 40px; padding-right: 40px; justify-content: flex-start; align-items: flex-start; gap: 32px; display: inline-flex">
    <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 8px; display: inline-flex">
      <div style="color: black; font-size: 40px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Filters</div>
      <div style="align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 20px; display: flex">
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(226, 31, 37, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Categories</div>
          <div style="width: 24px; height: 24px; position: relative">
            <div style="width: 12px; height: 7.40px; left: 6px; top: 8px; position: absolute; background: var(--Schemes-On-Surface, #1D1B20)"></div>
          </div>
        </div>
        <div style="align-self: stretch; height: 0px; outline: 1px #CCCCCC solid; outline-offset: -0.50px"></div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(226, 31, 37, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Location </div>
          <div style="width: 24px; height: 24px; position: relative">
            <div style="width: 12px; height: 7.40px; left: 6px; top: 8px; position: absolute; background: var(--Schemes-On-Surface, #1D1B20)"></div>
          </div>
        </div>
      </div>
    </div>
    <div style="width: 560px; align-self: stretch; overflow: hidden; flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: inline-flex">
      <div style="align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 8px; display: flex">
        <div style="align-self: stretch; height: 56px; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(226, 31, 37, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="color: black; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Secretary</div>
          <div style="width: 24px; height: 24px; position: relative">
            <div style="width: 18px; height: 18px; left: 3px; top: 3px; position: absolute; background: var(--Schemes-On-Surface, #1D1B20)"></div>
          </div>
        </div>
        <div style="justify-content: flex-start; align-items: flex-start; gap: 8px; display: inline-flex">
          <div style="color: black; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Searching For</div>
          <div style="color: black; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Secretary</div>
        </div>
      </div>
      <div style="align-self: stretch; flex: 1 1 0; overflow: hidden; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px; display: flex">
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Project Manager</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Abu Dhabi</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Software Developer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Riyadh</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Graphic Designer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Doha</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Civil Engineer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Kuwait City</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Marketing Specialist</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Muscat</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Data Analyst</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Manama</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; justify-content: space-between; align-items: center; display: inline-flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: inline-flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Sales Executive</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Jeddah</div>
            </div>
          </div>
          <div style="padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; justify-content: center; align-items: center; gap: 10px; display: flex">
            <div style="color: #2D78C9; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">View</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #2D78C9"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="flex: 1 1 0; align-self: stretch; overflow: hidden; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 8px; display: inline-flex">
      <div style="color: black; font-size: 24px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Trending Jobs</div>
      <div style="align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px; display: flex">
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 10px; display: flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Project Manager</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Abu Dhabi</div>
            </div>
          </div>
          <div style="align-self: stretch; height: 35px; padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; outline: 1px #2D78C9 solid; outline-offset: -1px; justify-content: center; align-items: center; gap: 10px; display: inline-flex">
            <div style="color: #4D4D4D; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Apply</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #4D4D4D"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 10px; display: flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Software Developer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Riyadh</div>
            </div>
          </div>
          <div style="align-self: stretch; height: 35px; padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; outline: 1px #2D78C9 solid; outline-offset: -1px; justify-content: center; align-items: center; gap: 10px; display: inline-flex">
            <div style="color: #4D4D4D; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Apply</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #4D4D4D"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 10px; display: flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Graphic Designer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Doha</div>
            </div>
          </div>
          <div style="align-self: stretch; height: 35px; padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; outline: 1px #2D78C9 solid; outline-offset: -1px; justify-content: center; align-items: center; gap: 10px; display: inline-flex">
            <div style="color: #4D4D4D; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Apply</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #4D4D4D"></div>
            </div>
          </div>
        </div>
        <div style="align-self: stretch; padding: 16px; background: white; box-shadow: 0px 0px 36px rgba(0, 122, 255, 0.08); border-radius: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 10px; display: flex">
          <div style="flex-direction: column; justify-content: center; align-items: flex-start; gap: 10px; display: flex">
            <div style="text-align: center; color: #1A1A1A; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Civil Engineer</div>
            <div style="justify-content: flex-start; align-items: center; gap: 10px; display: inline-flex">
              <div style="width: 24px; height: 24px; background: #D9D9D9"></div>
              <div style="width: 16px; height: 20px; background: #808080"></div>
              <div style="text-align: center; color: #808080; font-size: 16px; font-family: Source Sans Pro; font-weight: 400; word-wrap: break-word">Kuwait City</div>
            </div>
          </div>
          <div style="align-self: stretch; height: 35px; padding-left: 32px; padding-right: 32px; padding-top: 16px; padding-bottom: 16px; border-radius: 100px; outline: 1px #2D78C9 solid; outline-offset: -1px; justify-content: center; align-items: center; gap: 10px; display: inline-flex">
            <div style="color: #4D4D4D; font-size: 16px; font-family: Source Sans Pro; font-weight: 700; word-wrap: break-word">Apply</div>
            <div style="width: 24px; height: 24px; position: relative; transform: rotate(-180deg); transform-origin: top left">
              <div style="width: 16px; height: 16px; left: 4px; top: 4px; position: absolute; background: #4D4D4D"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection