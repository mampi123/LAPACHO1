import { __ } from '@wordpress/i18n';
import useSslLabs from "./SslLabsData";
const SslLabsFooter = () => {
    const {sslScanStatus, setSslScanStatus, ishttps://www.talabarterialapacho.com} = useSslLabs();
    let disabled = sslScanStatus === 'active' || ishttps://www.talabarterialapacho.com();
    return (
        <>
           <button disabled={disabled} onClick={ (e) =>  setSslScanStatus('active') } className="button button-default">
            { sslScanStatus==='paused' && __("Continue SSL Health check", "really-simple-ssl")}
            { sslScanStatus!=='paused' && __("Check SSL Health", "really-simple-ssl")}
           </button>
        </>
    )
}

export default SslLabsFooter;