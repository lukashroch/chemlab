import axios from 'axios';

export type SAPayloadVariables = {
  brandKey: string;
  catalogType: string;
  productKey: string;
};

export type SAPayload = {
  operationName: string;
  query: string;
  variables: PayloadVariables;
};

export type SABrand = {
  color: string;
  erpKey: string;
  key: string;
  name: string;
  __typename: string;
};

export type SABrowserMetadata = {
  description: string;
  keywords: string[];
  title: string;
  __typename: string;
};

export type SAImage = {
  altText: string;
  label: string;
  largeUrl: string;
  mediumUrl: string;
  smallUrl: string;
  __typename: string;
};

export type SACompliance = {
  images: SAImage[];
  key: string;
  label: string;
  value: string;
  __typename: string;
};

export type SAProductDetails = {
  aliases: any[];
  attributes: any[];
  brand: SABrand;
  browserMetadata: SABrowserMetadata;
  casNumber: string;
  catalogId: string;
  compliance: SACompliance[];
  complianceReach: any[];
  components: any;
  customPdpId: string;
  description: string;
  descriptions: any[];
  empiricalFormula: string;
  erpProductKey: string;
  features: string[];
  id: string;
  images: SAImage[];
  isMarketplace: boolean;
  isSial: boolean;
  linearFormula: string;
  links: any[];
  marketplaceOfferId: string | null;
  marketplaceSellerId: string | null;
  materialIds: string[];
  molecularWeight: string;
  name: string;
  paMessage: string | null;
  productCategories: any[];
  productKey: string;
  productNumber: string;
  productRating: {
    ratingEnabled: boolean;
    __typename: string;
  };
  relatedProducts: any[];
  sdsPnoKey: string;
  substance: {
    id: string;
    __typename: string;
  };
  substanceCount: number;
  synonyms: string[];
  type: string;
  __typename: string;
};

export type SAError = {
  extensions: { brandKey: string; code: string; productKey: string };
  locations: any[];
  message: string;
  path: string[];
};

export type SAProductDetailsResponse = {
  data: {
    getProductDetail: SAProductDetails | null;
  };
  errors?: SAError[];
};

const operationName = 'PDP';
const query = `query PDP($brandKey: String!, $productKey: String!, $catalogType: CatalogType, $orgId: String) {\n  getProductDetail(input: {brandKey: $brandKey, productKey: $productKey, catalogType: $catalogType, orgId: $orgId}) {\n    ...PDPFields\n    __typename\n  }\n}\n\nfragment PDPFields on Product {\n  id\n  productNumber\n  productKey\n  erpProductKey\n  isSial\n  isMarketplace\n  marketplaceSellerId\n  marketplaceOfferId\n  substance {\n    id\n    __typename\n  }\n  brand {\n    key\n    erpKey\n    name\n    logo {\n      altText\n      smallUrl\n      mediumUrl\n      largeUrl\n      __typename\n    }\n    cells {\n      altText\n      smallUrl\n      mediumUrl\n      largeUrl\n      __typename\n    }\n    color\n    __typename\n  }\n  aliases {\n    key\n    value\n    label\n    __typename\n  }\n  name\n  description\n  descriptions {\n    label\n    values\n    __typename\n  }\n  molecularWeight\n  empiricalFormula\n  linearFormula\n  casNumber\n  images {\n    altText\n    label\n    smallUrl\n    mediumUrl\n    largeUrl\n    __typename\n  }\n  synonyms\n  attributes {\n    key\n    label\n    values\n    __typename\n  }\n  materialIds\n  compliance {\n    key\n    label\n    value\n    images {\n      altText\n      smallUrl\n      mediumUrl\n      largeUrl\n      __typename\n    }\n    __typename\n  }\n  complianceReach {\n    key\n    label\n    value\n    casNos\n    __typename\n  }\n  browserMetadata {\n    title\n    description\n    keywords\n    __typename\n  }\n  sdsPnoKey\n  links {\n    label\n    key\n    anchorTag\n    image\n    __typename\n  }\n  features\n  paMessage\n  catalogId\n  components {\n    kitOnly {\n      value\n      pId\n      pno\n      brand\n      erpBrandKey\n      erpPnoKey\n      __typename\n    }\n    kitSoldSeparate {\n      value\n      pId\n      pno\n      brand\n      erpBrandKey\n      erpPnoKey\n      __typename\n    }\n    analyte {\n      value\n      pId\n      __typename\n    }\n    solvent {\n      value\n      pId\n      __typename\n    }\n    bulletin {\n      value\n      pId\n      __typename\n    }\n    __typename\n  }\n  substanceCount\n  productCategories {\n    category\n    url\n    __typename\n  }\n  relatedProducts {\n    type\n    productId\n    __typename\n  }\n  type\n  customPdpId\n  productRating {\n    ratingEnabled\n    __typename\n  }\n  __typename\n}\n`;

const createQueryPayload = (
  variables: Pick<SAPayloadVariables, 'brandKey' | 'productKey'>
): SAPayload => {
  return {
    operationName,
    query,
    variables: {
      catalogType: 'sial',
      ...variables,
    },
  };
};

const brandKeys = ['aldrich', 'sigma', 'sial', 'mm', 'supelco'];

export default {
  saClient: axios.create({
    baseURL: 'https://www.sigmaaldrich.com/api',
    headers: { 'x-gql-country': 'GB', 'x-gql-language': 'en' },
  }),

  async getProductDetails(brandKey: string, productKey: string): Promise<SAProductDetails | null> {
    const {
      data: {
        data: { getProductDetail },
      },
    } = await this.saClient.post<SAProductDetailsResponse>(
      '',
      createQueryPayload({ brandKey, productKey })
    );

    return getProductDetail;
  },

  async findProductDetails(productKey: string): Promise<SAProductDetails | null> {
    for (const brandKey of brandKeys) {
      try {
        const productDetails = await this.getProductDetails(brandKey, productKey);
        if (productDetails) return productDetails;
      } catch (err) {
        //
      }
    }

    return null;
  },
};
