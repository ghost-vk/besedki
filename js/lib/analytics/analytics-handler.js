import { loadAnalytics } from "./analytics-source";
import analytics from "./analytics-data";

export const startAnalyticsAfterLoading = async () => {
    try {
        await loadAnalytics()
        analytics.startAnalytics()
    } catch (err) {
        console.log('Failed when connecting to analytics systems ...')
    }
}